import json

def parse_sql():
    with open('blogs_rows.sql', 'r', encoding='utf-8') as f:
        content = f.read()

    # Split tuples by INSERT statement lines or pattern
    # Format: VALUES ('id', 'title', 'slug', 'content', 'excerpt', 'author_id', is_published, 'seo_title', 'seo_description', 'created_at', 'updated_at', scheduled_at)
    
    # We can search for string patterns starting with ('
    records = []
    
    # Find all occurrences of "('00" or "('" followed by UUID/ID
    import re
    raw_tuples = re.split(r",\s*\('([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})',", content)
    
    # If the first tuple starts at beginning
    if content.startswith("INSERT INTO"):
        first_match = re.search(r"VALUES\s*\('([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})',", content)
        if first_match:
            raw_tuples[0] = first_match.group(1)

    print(f"Total raw segments found: {len(raw_tuples)}")

    articles = []
    
    i = 1
    while i < len(raw_tuples):
        article_id = raw_tuples[i]
        body = raw_tuples[i+1]
        i += 2
        
        # Parse fields inside body
        # Structure: 'title', 'slug', 'content', 'excerpt', 'author_id', is_published, 'seo_title', 'seo_description', 'created_at', 'updated_at', scheduled_at)
        tokens = []
        in_string = False
        curr = []
        idx = 0
        length = len(body)
        
        while idx < length:
            ch = body[idx]
            if ch == "'":
                if in_string and idx + 1 < length and body[idx+1] == "'":
                    curr.append("'")
                    idx += 2
                    continue
                else:
                    in_string = not in_string
                    idx += 1
                    continue
            
            if not in_string and ch == ',':
                tokens.append(''.join(curr).strip())
                curr = []
                idx += 1
                continue
                
            curr.append(ch)
            idx += 1
            
        if curr:
            tokens.append(''.join(curr).strip())
            
        if len(tokens) >= 8:
            title = tokens[0]
            slug = tokens[1]
            content_text = tokens[2]
            excerpt = tokens[3]
            author_id = tokens[4]
            is_published = tokens[5].lower() == 'true'
            seo_title = tokens[6]
            seo_description = tokens[7]
            created_at = tokens[8] if len(tokens) > 8 else ''
            updated_at = tokens[9] if len(tokens) > 9 else ''

            articles.append({
                'id': article_id,
                'title': title,
                'slug': slug,
                'content': content_text,
                'excerpt': excerpt,
                'author_id': author_id,
                'is_published': is_published,
                'seo_title': seo_title,
                'seo_description': seo_description,
                'created_at': created_at,
                'updated_at': updated_at
            })

    print(f"Successfully extracted {len(articles)} complete articles.")
    with open('imported_blogs.json', 'w', encoding='utf-8') as out:
        json.dump(articles, out, ensure_ascii=False, indent=2)

if __name__ == '__main__':
    parse_sql()
