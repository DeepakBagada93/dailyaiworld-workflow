#!/usr/bin/env python3
import sys
import os
import re
import subprocess

def parse_sql_values(sql_path):
    with open(sql_path, 'r', encoding='utf-8') as f:
        content = f.read()

    match = re.search(r'VALUES\s*(.*);', content, re.DOTALL | re.IGNORECASE)
    if not match:
        print("Could not find VALUES clause")
        return []

    values_str = match.group(1).strip()
    
    records = []
    current_tuple = []
    in_quotes = False
    current_val = []
    in_tuple = False

    i = 0
    length = len(values_str)
    
    while i < length:
        char = values_str[i]
        
        if not in_tuple:
            if char == '(':
                in_tuple = True
                current_tuple = []
                current_val = []
                in_quotes = False
            i += 1
            continue

        if in_quotes:
            if char == "'" and i + 1 < length and values_str[i+1] == "'":
                current_val.append("'")
                i += 2
                continue
            elif char == "'":
                in_quotes = False
                i += 1
                continue
            else:
                current_val.append(char)
                i += 1
                continue
        else:
            if char == "'":
                in_quotes = True
                i += 1
                continue
            elif char == ',':
                val_str = "".join(current_val).strip()
                if val_str.upper() == 'NULL':
                    current_tuple.append(None)
                elif val_str.lower() == 'true':
                    current_tuple.append(True)
                elif val_str.lower() == 'false':
                    current_tuple.append(False)
                else:
                    current_tuple.append(val_str)
                current_val = []
                i += 1
                continue
            elif char == ')':
                val_str = "".join(current_val).strip()
                if val_str.upper() == 'NULL':
                    current_tuple.append(None)
                elif val_str.lower() == 'true':
                    current_tuple.append(True)
                elif val_str.lower() == 'false':
                    current_tuple.append(False)
                else:
                    current_tuple.append(val_str)
                
                records.append(current_tuple)
                in_tuple = False
                i += 1
                continue
            else:
                current_val.append(char)
                i += 1
                continue

    return records

def escape_sql(val):
    if val is None:
        return "''"
    if isinstance(val, bool):
        return 'TRUE' if val else 'FALSE'
    escaped = str(val).replace('\\', '\\\\').replace("'", "''")
    return f"'{escaped}'"

def main():
    sql_file = 'blogs_rows.sql'
    if not os.path.exists(sql_file):
        print(f"File {sql_file} not found!")
        sys.exit(1)

    print("Parsing blogs_rows.sql...")
    records = parse_sql_values(sql_file)
    print(f"Parsed {len(records)} blog posts from SQL.")

    out_sql = "import_converted_blogs.sql"
    with open(out_sql, "w", encoding="utf-8") as f:
        f.write("SET FOREIGN_KEY_CHECKS=0;\n")
        
        post_id = 100
        for rec in records:
            if len(rec) < 11:
                continue
            
            b_id, title, slug, content, excerpt, author_id, is_published, seo_title, seo_description, created_at, updated_at = rec[:11]

            if not title or not content:
                continue
            
            excerpt = excerpt or ""
            created_at = created_at or "2026-07-24 07:00:00"
            created_at_clean = str(created_at).split('.')[0]

            sql_post = f"INSERT INTO wp_posts (ID, post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_type) VALUES ({post_id}, 1, {escape_sql(created_at_clean)}, {escape_sql(created_at_clean)}, {escape_sql(content)}, {escape_sql(title)}, {escape_sql(excerpt)}, 'publish', 'open', 'open', {escape_sql(slug)}, '', '', {escape_sql(created_at_clean)}, {escape_sql(created_at_clean)}, '', 'post') ON DUPLICATE KEY UPDATE post_title={escape_sql(title)}, post_content={escape_sql(content)};\n"
            f.write(sql_post)

            if seo_title:
                f.write(f"INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ({post_id}, 'rank_math_title', {escape_sql(seo_title)});\n")
            if seo_description:
                f.write(f"INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ({post_id}, 'rank_math_description', {escape_sql(seo_description)});\n")

            post_id += 1

        f.write("SET FOREIGN_KEY_CHECKS=1;\n")

    print(f"Generated {out_sql} with {post_id - 100} MySQL insert statements.")

    print("Importing into MySQL dailyaiworld_db...")
    cmd = f"/opt/homebrew/bin/mysql -u root dailyaiworld_db < {out_sql}"
    res = subprocess.run(cmd, shell=True, capture_output=True, text=True)
    if res.returncode == 0:
        print("Successfully imported all blog posts into MySQL dailyaiworld_db!")
    else:
        print("MySQL Import error:", res.stderr)

if __name__ == "__main__":
    main()
