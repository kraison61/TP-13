"""
Import missing data from example/theeraphong.sql into database/database.sqlite.

Maps legacy schema differences:
  - services.content_1 + content_2 -> content
  - services.img_1, img_2
  - image_uploads.service_id/phase_id -> morph imageable
  - prices -> service_prices (column/type renames)
"""
from __future__ import annotations

import sqlite3
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(ROOT))

from tmp_merge_service_content import COLS, parse_sql_values  # noqa: E402

SQL_PATH = ROOT / "example" / "theeraphong.sql"
DB_PATH = ROOT / "database" / "database.sqlite"

SERVICE_TYPE = "App\\Models\\Service"
PHASE_TYPE = "App\\Models\\ProjectPhase"

PRICE_TYPE_MAP = {
    "exact": "fixed",
    "starting": "starting_at",
    "range": "range",
    "variable": "variable",
}

# Legacy prices.service_id values that no longer match services.id in the dump.
PRICE_SERVICE_OVERRIDES: dict[int, int] = {
    4: 4,    # landfill tiers (ถมดิน)
    10: 10,  # retaining-wall tiers (กำแพงกันดิน)
    26: 15,  # dam
    28: 17,  # fence
}

PRICE_COLS = [
    "id",
    "service_id",
    "sku",
    "name",
    "description",
    "price",
    "max_price",
    "sale_price",
    "price_type",
    "unit_text",
    "currency",
    "price_valid_until",
    "availability",
    "url",
    "sort_order",
    "is_active",
    "created_at",
    "updated_at",
]

IMAGE_COLS = [
    "id",
    "phase_id",
    "service_id",
    "img_url",
    "created_at",
    "updated_at",
    "location",
    "worked_date",
]

LABOR_CAT_COLS = ["id", "name", "parent_id", "created_at", "updated_at"]

LABOR_COST_COLS = [
    "id",
    "category_id",
    "item_name",
    "unit",
    "cost_per_unit",
    "remark",
    "document_ref",
    "created_at",
    "updated_at",
]

BLOG_COLS = [
    "id",
    "title",
    "description",
    "content",
    "image",
    "service_category_id",
    "slug",
    "created_at",
    "updated_at",
]

LEGACY_CATEGORY_COLS = ["id", "name", "created_at", "updated_at", "slug"]


def read_sql() -> str:
    return SQL_PATH.read_text(encoding="utf-8")


def extract_table_rows(text: str, table: str, columns: list[str]) -> list[dict]:
    needle = f"INSERT INTO `{table}`"
    rows: list[dict] = []
    pos = 0

    while True:
        start = text.find(needle, pos)
        if start == -1:
            break
        values_idx = text.find("VALUES", start)
        semi = text.find(";\n", values_idx)
        if semi == -1:
            semi = text.find(";", values_idx)
        block = text[values_idx + 6 : semi]
        for row in parse_sql_values(block):
            if len(row) < len(columns):
                continue
            rows.append(dict(zip(columns, row)))
        pos = semi + 1

    return rows


def extract_services(text: str) -> dict[int, dict]:
    services: dict[int, dict] = {}

    for data in extract_table_rows(text, "services", COLS):
        sid = int(data["id"])
        c1 = data["content_1"] or ""
        c2 = data["content_2"] or ""
        services[sid] = {
            "title": data["title"],
            "h1": (data["h1"] or "").strip(),
            "description": data["description"],
            "content": c1 + c2,
            "img_1": data.get("img_1"),
            "img_2": data.get("img_2"),
            "rating_value": data.get("rating_value"),
            "review_count": data.get("review_count"),
            "schema_type": data.get("schema_type"),
        }

    return services


def ensure_service_image_columns(cur: sqlite3.Cursor) -> None:
    cur.execute("PRAGMA table_info(services)")
    cols = {row[1] for row in cur.fetchall()}
    if "img_1" not in cols:
        cur.execute("ALTER TABLE services ADD COLUMN img_1 varchar")
    if "img_2" not in cols:
        cur.execute("ALTER TABLE services ADD COLUMN img_2 varchar")


def build_service_id_map(cur: sqlite3.Cursor, sql_services: list[dict]) -> dict[int, int]:
    """Map legacy SQL service id -> current database service id (matched by h1, then title)."""
    db_rows = cur.execute("SELECT id, slug, title, h1 FROM services").fetchall()
    sql_by_h1 = {(r.get("h1") or "").strip(): r for r in sql_services if (r.get("h1") or "").strip()}
    sql_by_title = {(r.get("title") or "").strip(): r for r in sql_services}

    mapping: dict[int, int] = {}
    unmatched_db: list[tuple] = []

    for db_id, slug, title, h1 in db_rows:
        h1_key = (h1 or "").strip()
        sql_row = sql_by_h1.get(h1_key)

        if not sql_row:
            title_key = (title or "").strip()
            sql_row = sql_by_title.get(title_key)

        if not sql_row and slug == "pipe":
            sql_row = next(
                (r for r in sql_services if "ท่อ" in (r.get("title") or "") or "pipe" in (r.get("title") or "").lower()),
                None,
            )

        if sql_row:
            mapping[int(sql_row["id"])] = db_id
        else:
            unmatched_db.append((db_id, slug, title))

    if unmatched_db:
        print("  Warning: could not map DB services:")
        for db_id, slug, title in unmatched_db:
            print(f"    db_id={db_id} slug={slug} title={title[:40]}")

    return mapping


def import_services(cur: sqlite3.Cursor, services: dict[int, dict], id_map: dict[int, int]) -> int:
    ensure_service_image_columns(cur)
    updated = 0

    for sql_id, src in sorted(services.items()):
        db_id = id_map.get(sql_id)
        if not db_id:
            print(f"  skip SQL service id={sql_id} (no DB mapping)")
            continue

        cur.execute(
            """
            UPDATE services
            SET content = ?,
                img_1 = ?,
                img_2 = ?,
                rating_value = COALESCE(?, rating_value),
                review_count = COALESCE(?, review_count),
                schema_type = COALESCE(?, schema_type)
            WHERE id = ?
            """,
            (
                src["content"],
                src["img_1"],
                src["img_2"],
                src["rating_value"],
                src["review_count"],
                src["schema_type"],
                db_id,
            ),
        )
        updated += 1
        img = (src["img_1"] or "-")[:50]
        print(f"  sql_id={sql_id:2} -> db_id={db_id:2} content={len(src['content']):6} img_1={img}")

    return updated


def import_image_uploads(cur: sqlite3.Cursor, rows: list[dict], id_map: dict[int, int]) -> int:
    cur.execute("DELETE FROM image_uploads")
    inserted = 0

    for row in rows:
        service_id = row.get("service_id")
        phase_id = row.get("phase_id")
        has_phase = phase_id and str(phase_id).upper() != "NULL"
        has_service = service_id and str(service_id).upper() != "NULL"

        if has_phase:
            imageable_type = PHASE_TYPE
            imageable_id = int(phase_id)
        elif has_service:
            mapped_id = id_map.get(int(service_id))
            if not mapped_id:
                continue
            imageable_type = SERVICE_TYPE
            imageable_id = mapped_id
        else:
            continue

        cur.execute(
            """
            INSERT INTO image_uploads
                (imageable_type, imageable_id, img_url, location, worked_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)
            """,
            (
                imageable_type,
                imageable_id,
                row["img_url"],
                row.get("location"),
                row.get("worked_date"),
                row.get("created_at"),
                row.get("updated_at"),
            ),
        )
        inserted += 1

    return inserted


def import_labor_categories(cur: sqlite3.Cursor, rows: list[dict]) -> int:
    cur.execute("DELETE FROM labor_costs")
    cur.execute("DELETE FROM labor_categories")
    inserted = 0

    for row in rows:
        cur.execute(
            """
            INSERT INTO labor_categories (id, name, parent_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?)
            """,
            (
                int(row["id"]),
                row["name"],
                int(row["parent_id"]) if row.get("parent_id") else None,
                row.get("created_at"),
                row.get("updated_at"),
            ),
        )
        inserted += 1

    return inserted


def import_labor_costs(cur: sqlite3.Cursor, rows: list[dict]) -> int:
    inserted = 0

    for row in rows:
        cur.execute(
            """
            INSERT INTO labor_costs
                (id, category_id, item_name, unit, cost_per_unit, remark, document_ref, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            """,
            (
                int(row["id"]),
                int(row["category_id"]),
                row["item_name"],
                row["unit"],
                row["cost_per_unit"],
                row.get("remark"),
                row.get("document_ref") or "ว 809",
                row.get("created_at"),
                row.get("updated_at"),
            ),
        )
        inserted += 1

    return inserted


def import_service_prices(cur: sqlite3.Cursor, rows: list[dict], id_map: dict[int, int]) -> int:
    cur.execute("DELETE FROM service_prices WHERE sku IS NOT NULL AND sku != ''")

    inserted = 0
    updated = 0

    for row in rows:
        sql_service_id = int(row["service_id"])
        service_id = PRICE_SERVICE_OVERRIDES.get(sql_service_id) or id_map.get(sql_service_id)
        if not service_id:
            continue

        price_type = PRICE_TYPE_MAP.get(row.get("price_type") or "exact", "fixed")
        sku = row.get("sku") or None
        name = row["name"]

        cur.execute(
            """
            SELECT id FROM service_prices
            WHERE service_id = ? AND (
                (sku IS NOT NULL AND sku = ?) OR (sku IS NULL AND name = ?)
            )
            """,
            (service_id, sku, name),
        )
        existing = cur.fetchone()

        values = (
            service_id,
            sku,
            name,
            row.get("description"),
            price_type,
            row.get("price"),
            row.get("max_price"),
            row.get("sale_price"),
            row.get("unit_text"),
            row.get("currency") or "THB",
            row.get("price_valid_until"),
            row.get("availability") or "https://schema.org/InStock",
            int(row.get("sort_order") or 0),
            1 if str(row.get("is_active", "1")) in ("1", "true", "True") else 0,
            row.get("created_at"),
            row.get("updated_at"),
        )

        if existing:
            cur.execute(
                """
                UPDATE service_prices SET
                    name = ?, description = ?, price_type = ?, price = ?,
                    max_price = ?, discount_price = ?, unit = ?,
                    price_currency = ?, price_valid_until = ?, availability = ?,
                    sort_order = ?, is_active = ?, updated_at = ?
                WHERE id = ?
                """,
                (
                    name,
                    row.get("description"),
                    price_type,
                    row.get("price"),
                    row.get("max_price"),
                    row.get("sale_price"),
                    row.get("unit_text"),
                    row.get("currency") or "THB",
                    row.get("price_valid_until"),
                    row.get("availability") or "https://schema.org/InStock",
                    int(row.get("sort_order") or 0),
                    1 if str(row.get("is_active", "1")) in ("1", "true", "True") else 0,
                    row.get("updated_at"),
                    existing[0],
                ),
            )
            updated += 1
        else:
            cur.execute(
                """
                INSERT INTO service_prices (
                    service_id, sku, name, description, price_type, price, max_price,
                    discount_price, unit, price_currency, price_valid_until, availability,
                    sort_order, is_active, created_at, updated_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                """,
                values,
            )
            inserted += 1

    return inserted + updated


def ensure_blogs_table(cur: sqlite3.Cursor) -> None:
    cur.execute("SELECT name FROM sqlite_master WHERE type='table' AND name='blogs'")
    if cur.fetchone():
        cur.execute("PRAGMA table_info(blogs)")
        cols = {row[1] for row in cur.fetchall()}
        if "service_id" not in cols:
            cur.execute("ALTER TABLE blogs ADD COLUMN service_id INTEGER")
        if "author" not in cols:
            cur.execute("ALTER TABLE blogs ADD COLUMN author varchar NOT NULL DEFAULT 'ทีมงาน'")
        if "cover_image" not in cols:
            cur.execute("ALTER TABLE blogs ADD COLUMN cover_image varchar")
        return

    cur.execute(
        """
        CREATE TABLE blogs (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            title varchar NOT NULL,
            slug varchar NOT NULL,
            description varchar NOT NULL,
            content TEXT NOT NULL,
            cover_image varchar,
            created_at datetime,
            updated_at datetime,
            service_id INTEGER,
            author varchar NOT NULL DEFAULT 'ทีมงาน',
            FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
        )
        """
    )


def build_legacy_category_slug_map(text: str) -> dict[int, str]:
    rows = extract_table_rows(text, "service_categories", LEGACY_CATEGORY_COLS)
    return {int(row["id"]): row["slug"] for row in rows}


def build_service_slug_to_id(cur: sqlite3.Cursor) -> dict[str, int]:
    return {slug: db_id for db_id, slug in cur.execute("SELECT id, slug FROM services").fetchall()}


def import_blogs(
    cur: sqlite3.Cursor,
    rows: list[dict],
    category_slug_map: dict[int, str],
    service_slug_to_id: dict[str, int],
) -> int:
    ensure_blogs_table(cur)
    upserted = 0

    for row in rows:
        legacy_category_id = int(row["service_category_id"])
        category_slug = category_slug_map.get(legacy_category_id)
        service_id = service_slug_to_id.get(category_slug) if category_slug else None
        slug = row["slug"]

        cur.execute("SELECT id FROM blogs WHERE slug = ?", (slug,))
        existing = cur.fetchone()

        if existing:
            cur.execute(
                """
                UPDATE blogs SET
                    title = ?,
                    description = ?,
                    content = ?,
                    cover_image = ?,
                    service_id = ?,
                    updated_at = ?
                WHERE slug = ?
                """,
                (
                    row["title"],
                    row["description"],
                    row["content"],
                    row.get("image"),
                    service_id,
                    row.get("updated_at"),
                    slug,
                ),
            )
        else:
            cur.execute(
                """
                INSERT INTO blogs (
                    id, title, slug, description, content, cover_image,
                    service_id, author, created_at, updated_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, 'ทีมงาน', ?, ?)
                """,
                (
                    int(row["id"]),
                    row["title"],
                    slug,
                    row["description"],
                    row["content"],
                    row.get("image"),
                    service_id,
                    row.get("created_at"),
                    row.get("updated_at"),
                ),
            )

        upserted += 1
        title_preview = (row["title"] or "")[:40]
        print(
            f"  id={int(row['id']):2} slug={slug[:36]:36} service_id={service_id or '-':>2} {title_preview}"
        )

    return upserted


def print_summary(cur: sqlite3.Cursor) -> None:
    print("\n=== Summary ===")
    checks = [
        ("services with img_1", "SELECT COUNT(*) FROM services WHERE img_1 IS NOT NULL AND img_1 != ''"),
        ("image_uploads", "SELECT COUNT(*) FROM image_uploads"),
        ("image_uploads (Service)", f"SELECT COUNT(*) FROM image_uploads WHERE imageable_type = '{SERVICE_TYPE}'"),
        ("labor_categories", "SELECT COUNT(*) FROM labor_categories"),
        ("labor_costs", "SELECT COUNT(*) FROM labor_costs"),
        ("service_prices", "SELECT COUNT(*) FROM service_prices"),
        ("blogs", "SELECT COUNT(*) FROM blogs"),
    ]
    for label, sql in checks:
        cur.execute(sql)
        print(f"  {label}: {cur.fetchone()[0]}")


def main() -> None:
    if not SQL_PATH.exists():
        raise SystemExit(f"SQL file not found: {SQL_PATH}")
    if not DB_PATH.exists():
        raise SystemExit(f"Database not found: {DB_PATH}")

    text = read_sql()
    sql_service_rows = extract_table_rows(text, "services", COLS)
    services = extract_services(text)
    image_rows = extract_table_rows(text, "image_uploads", IMAGE_COLS)
    labor_cat_rows = extract_table_rows(text, "labor_categories", LABOR_CAT_COLS)
    labor_cost_rows = extract_table_rows(text, "labor_costs", LABOR_COST_COLS)
    price_rows = extract_table_rows(text, "prices", PRICE_COLS)
    blog_rows = extract_table_rows(text, "blogs", BLOG_COLS)
    category_slug_map = build_legacy_category_slug_map(text)

    print(f"Parsed from SQL:")
    print(f"  services: {len(services)}")
    print(f"  image_uploads: {len(image_rows)}")
    print(f"  labor_categories: {len(labor_cat_rows)}")
    print(f"  labor_costs: {len(labor_cost_rows)}")
    print(f"  prices: {len(price_rows)}")
    print(f"  blogs: {len(blog_rows)}")

    conn = sqlite3.connect(DB_PATH)
    cur = conn.cursor()

    id_map = build_service_id_map(cur, sql_service_rows)
    service_slug_to_id = build_service_slug_to_id(cur)
    print(f"\nService ID map ({len(id_map)} entries): {sorted(id_map.items())}")

    print("\n[1/5] Importing services (content, img_1, img_2)...")
    n = import_services(cur, services, id_map)
    print(f"  -> {n} services updated")

    print("\n[2/5] Importing image_uploads...")
    n = import_image_uploads(cur, image_rows, id_map)
    print(f"  -> {n} image_uploads inserted")

    print("\n[3/5] Importing labor_categories + labor_costs...")
    n_cat = import_labor_categories(cur, labor_cat_rows)
    n_cost = import_labor_costs(cur, labor_cost_rows)
    print(f"  -> {n_cat} labor_categories, {n_cost} labor_costs")

    print("\n[4/5] Importing service_prices from prices...")
    n = import_service_prices(cur, price_rows, id_map)
    print(f"  -> {n} service_prices upserted")

    print("\n[5/5] Importing blogs...")
    n = import_blogs(cur, blog_rows, category_slug_map, service_slug_to_id)
    print(f"  -> {n} blogs upserted")

    conn.commit()
    print_summary(cur)
    conn.close()
    print("\nDone.")


if __name__ == "__main__":
    main()
