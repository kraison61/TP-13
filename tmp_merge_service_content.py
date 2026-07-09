"""Merge services.content_1 + content_2 from theeraphong.sql into database.sqlite services.content."""
import sqlite3
from pathlib import Path

SQL_PATH = Path(__file__).parent / "example" / "theeraphong.sql"
DB_PATH = Path(__file__).parent / "database" / "database.sqlite"

COLS = [
    "id",
    "service_category_id",
    "title",
    "description",
    "h1",
    "top_1",
    "top_2",
    "content_1",
    "content_2",
    "img_1",
    "img_2",
    "created_at",
    "updated_at",
    "top_alt",
    "bottom_alt",
    "rating_value",
    "review_count",
    "schema_type",
    "is_active",
]


def parse_sql_values(values_str: str) -> list[list[str | None]]:
    rows: list[list[str | None]] = []
    i = 0
    n = len(values_str)

    while i < n:
        while i < n and values_str[i] in " \t\r\n,":
            i += 1
        if i >= n:
            break
        if values_str[i] != "(":
            i += 1
            continue

        i += 1
        fields: list[str | None] = []
        while i < n:
            while i < n and values_str[i] in " \t\r\n":
                i += 1
            if i >= n:
                break
            if values_str[i] == ")":
                i += 1
                rows.append(fields)
                break
            if values_str[i] == ",":
                i += 1
                continue
            if values_str[i : i + 4].upper() == "NULL":
                fields.append(None)
                i += 4
                continue
            if values_str[i] == "'":
                i += 1
                buf: list[str] = []
                while i < n:
                    c = values_str[i]
                    if c == "'":
                        if i + 1 < n and values_str[i + 1] == "'":
                            buf.append("'")
                            i += 2
                            continue
                        i += 1
                        break
                    if c == "\\" and i + 1 < n:
                        nxt = values_str[i + 1]
                        esc = {"n": "\n", "r": "\r", "t": "\t", "\\": "\\", "'": "'"}
                        buf.append(esc.get(nxt, nxt))
                        i += 2
                        continue
                    buf.append(c)
                    i += 1
                fields.append("".join(buf))
                continue

            start = i
            while i < n and values_str[i] not in ",)":
                i += 1
            fields.append(values_str[start:i].strip())

    return rows


def extract_services(text: str) -> dict[int, dict]:
    needle = "INSERT INTO `services`"
    services: dict[int, dict] = {}
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
        rows = parse_sql_values(block)

        for row in rows:
            if len(row) < len(COLS):
                continue
            data = dict(zip(COLS, row))
            sid = int(data["id"])
            c1 = data["content_1"] or ""
            c2 = data["content_2"] or ""
            services[sid] = {
                "title": data["title"],
                "h1": (data["h1"] or "").strip(),
                "content_1": c1,
                "content_2": c2,
                "content": c1 + c2,
            }
        pos = semi + 1

    return services


def main() -> None:
    text = SQL_PATH.read_text(encoding="utf-8")
    services = extract_services(text)
    print(f"Parsed {len(services)} services from SQL")

    conn = sqlite3.connect(DB_PATH)
    cur = conn.cursor()
    cur.execute("SELECT id, slug, title, h1, length(COALESCE(content, '')) FROM services ORDER BY id")
    db_rows = cur.fetchall()
    print(f"Database has {len(db_rows)} services")

    sql_by_h1: dict[str, dict] = {}
    for svc in services.values():
        h1 = svc["h1"]
        if h1:
            sql_by_h1[h1] = svc

    updated = 0
    missing = []
    for sid, slug, title, h1, old_len in db_rows:
        h1_key = (h1 or "").strip()
        if h1_key not in sql_by_h1:
            missing.append((sid, slug, title, h1_key))
            continue
        src = sql_by_h1[h1_key]
        new_content = src["content"]
        cur.execute("UPDATE services SET content = ? WHERE id = ?", (new_content, sid))
        updated += 1
        print(
            f"  id={sid:2} {slug:18} "
            f"c1={len(src['content_1']):6} "
            f"c2={len(src['content_2']):6} "
            f"old={old_len:6} new={len(new_content):6}"
        )

    conn.commit()
    conn.close()

    print(f"\nUpdated {updated} services")
    if missing:
        print(f"Missing in SQL by h1 ({len(missing)}):")
        for sid, slug, title, h1_key in missing:
            print(f"  id={sid} {slug} | {title} | h1={h1_key[:80]}")


if __name__ == "__main__":
    main()
