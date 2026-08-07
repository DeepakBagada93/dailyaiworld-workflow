import json
import re
import sys

def audit_article(article, index):
    errors = []

    # 1. Pure Markdown format check (no raw HTML tags like <h2>, <p>, <pre>, <code>)
    content = article.get('content', '')
    raw_html_tags = re.findall(r'</?(?:h[1-6]|p|pre|code|div|span|ul|ol|li)\b[^>]*>', content, re.IGNORECASE)
    if raw_html_tags:
        errors.append(f"Contains {len(raw_html_tags)} raw HTML tags (e.g. {raw_html_tags[:3]}) instead of pure Markdown.")

    # 2. Internal link domain check
    internal_links = re.findall(r'\[([^\]]+)\]\((https://dailyaiworld\.com/[^\)]+)\)', content)
    if not internal_links:
        errors.append("Missing live internal links to https://dailyaiworld.com/ (e.g., /workflows, /mcp-directory, /latest-ai-news).")

    # 3. E-E-A-T practitioner byline check
    if "Deepak Bagada" not in content:
        errors.append("Missing mandatory practitioner byline 'By Deepak Bagada, CEO at SaaSNext'.")

    # 4. FAQ structure check
    faqs = article.get('faqs', [])
    if not isinstance(faqs, list) or len(faqs) < 1:
        errors.append("Missing or invalid 'faqs' array.")
    else:
        for f_idx, f in enumerate(faqs):
            if not isinstance(f, dict):
                errors.append(f"FAQ item {f_idx} is not an object.")
            elif not ('question' in f or 'q' in f) or not ('answer' in f or 'a' in f):
                errors.append(f"FAQ item {f_idx} missing question/answer keys.")

    # 5. Word count check (minimum 1,200 words)
    words = len(content.split())
    if words < 1200:
        errors.append(f"Word count ({words} words) is below the mandatory 1,200-word minimum.")

    return errors

def main():
    payload_file = sys.argv[1] if len(sys.argv) > 1 else 'dispatches_payload.json'
    try:
        with open(payload_file, 'r') as f:
            dispatches = json.load(f)
    except Exception as e:
        print(f"FAILED: Unable to read {payload_file}: {e}")
        sys.exit(1)

    print(f"=== AUDITING {len(dispatches)} DISPATCHES ===")
    total_errors = 0

    for idx, art in enumerate(dispatches):
        title = art.get('title', f'Article #{idx+1}')
        errs = audit_article(art, idx)
        if errs:
            total_errors += len(errs)
            print(f"[REJECTED] Article #{idx+1}: {title}")
            for err in errs:
                print(f"  ❌ {err}")
        else:
            print(f"[PASSED] Article #{idx+1}: {title} ({len(art.get('content', '').split())} words)")

    if total_errors > 0:
        print(f"\nAUDIT FAILED: Found {total_errors} quality/formatting error(s). DO NOT PUSH TO DB!")
        sys.exit(1)
    else:
        print("\nAUDIT PASSED: All dispatches satisfy 100% SEO, AEO, HEO, and Markdown standards! Safe to push.")
        sys.exit(0)

if __name__ == '__main__':
    main()
