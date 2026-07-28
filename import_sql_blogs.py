import re
import mysql.connector
import sys
from datetime import datetime

def parse_sql_values(sql_file):
    with open(sql_file, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find the INSERT statements
    # Pattern: INSERT INTO ... VALUES (...)
    records = []
    
    # Simple state-machine parser for SQL VALUES (...)
    # We look for tuples: ('id', 'title', 'slug', 'content', 'excerpt', 'author_id', is_published, 'seo_title', 'seo_description', 'created_at', 'updated_at', scheduled_at)
    
    pos = 0
    length = len(content)
    
    while pos < length:
        # Find start of a tuple: ('
        start = content.find("('", pos)
        if start == -1:
            break
            
        # Parse fields inside this tuple
        fields = []
        i = start + 1 # skip (
        
        while i < length:
            # Check if end of tuple: )
            if content[i] == ')':
                # Check next chars for , or ; or \n to confirm end of tuple
                next_char = content[i+1:i+3].strip()
                if next_char.startswith(',') or next_char.startswith(';') or next_char == '':
                    pos = i + 1
                    break
            
            # String field starting with '
            if content[i] == "'":
                start_str = i + 1
                end_str = start_str
                while end_str < length:
                    if content[end_str] == "'":
                        if end_str + 1 < length and content[end_str + 1] == "'":
                            # Escaped single quote ''
                            end_str += 2
                        else:
                            # End of string
                            break
                    else:
                        end_str += 1
                
                val = content[start_str:end_str].replace("''", "'")
                fields.append(val)
                i = end_str + 1
                # Skip comma and spaces
                while i < length and (content[i] in (',', ' ', '\n', '\r', '\t')):
                    i += 1
            elif content[i:i+4] == 'NULL' or content[i:i+4] == 'null':
                fields.append(None)
                i += 4
                while i < length and (content[i] in (',', ' ', '\n', '\r', '\t')):
                    i += 1
            elif content[i:i+4] == 'true' or content[i:i+4] == 'TRUE':
                fields.append(True)
                i += 4
                while i < length and (content[i] in (',', ' ', '\n', '\r', '\t')):
                    i += 1
            elif content[i:i+5] == 'false' or content[i:i+5] == 'FALSE':
                fields.append(False)
                i += 5
                while i < length and (content[i] in (',', ' ', '\n', '\r', '\t')):
                    i += 1
            else:
                # Unquoted value (number or identifier)
                start_num = i
                while i < length and content[i] not in (',', ')', ' ', '\n', '\r', '\t'):
                    i += 1
                val = content[start_num:i].strip()
                if val:
                    fields.append(val)
                while i < length and (content[i] in (',', ' ', '\n', '\r', '\t')):
                    i += 1

        if len(fields) >= 9:
            records.append(fields)
        else:
            pos += 1

    return records

if __name__ == '__main__':
    print("Parsing blogs_rows.sql...")
    records = parse_sql_values('blogs_rows.sql')
    print(f"Parsed {len(records)} records successfully.")
