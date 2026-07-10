import sqlite3
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(ROOT))

from scripts.import_theeraphong_sql import COLS, extract_table_rows, read_sql

text = read_sql()
sql_rows = {int(r["id"]): r for r in extract_table_rows(text, "services", COLS)}

conn = sqlite3.connect(ROOT / "database" / "database.sqlite")
db_rows = conn.execute(
    "SELECT id, slug, title, h1, img_1, length(content) FROM services ORDER BY id"
).fetchall()

print(f"{'id':>3} {'slug':18} {'match':8} DB title / SQL title")
print("-" * 80)
for sid, slug, title, h1, img1, clen in db_rows:
    s = sql_rows.get(sid)
    if not s:
        print(f"{sid:3} {slug:18} {'MISSING':8} {title}")
        continue
    stitle = s["title"]
    ok = stitle == title or stitle[:15] in title or title[:15] in stitle
    flag = "OK" if ok else "MISMATCH"
    print(f"{sid:3} {slug:18} {flag:8} DB:{title[:30]}")
    if not ok:
        print(f"     {'':18} {'':8} SQL:{stitle[:30]}")
    print(f"     img_1={img1 or '-'}")

conn.close()
