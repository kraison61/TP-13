"""Import blogs from example/theeraphong.sql into database/database.sqlite."""
from __future__ import annotations

import sqlite3
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(ROOT))

from scripts.import_theeraphong_sql import (  # noqa: E402
    BLOG_COLS,
    DB_PATH,
    SQL_PATH,
    build_legacy_category_slug_map,
    build_service_slug_to_id,
    extract_table_rows,
    import_blogs,
    read_sql,
)


def main() -> None:
    if not SQL_PATH.exists():
        raise SystemExit(f"SQL file not found: {SQL_PATH}")
    if not DB_PATH.exists():
        raise SystemExit(f"Database not found: {DB_PATH}")

    text = read_sql()
    blog_rows = extract_table_rows(text, "blogs", BLOG_COLS)
    category_slug_map = build_legacy_category_slug_map(text)

    print(f"Parsed blogs from SQL: {len(blog_rows)}")

    conn = sqlite3.connect(DB_PATH)
    cur = conn.cursor()
    service_slug_to_id = build_service_slug_to_id(cur)

    print("\nImporting blogs...")
    n = import_blogs(cur, blog_rows, category_slug_map, service_slug_to_id)
    conn.commit()

    cur.execute("SELECT COUNT(*) FROM blogs")
    total = cur.fetchone()[0]
    conn.close()

    print(f"\n-> {n} blogs upserted ({total} total in database)")
    print("Done.")


if __name__ == "__main__":
    main()
