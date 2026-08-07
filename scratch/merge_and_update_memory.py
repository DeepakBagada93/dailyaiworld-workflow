import json

workflow_cid = "09cfa684-44fb-4d7e-98f4-91f4ae70804b"
mcp_cid = "6c04ed6c-f7b1-4dad-9599-5269918323e9"
blog_cid = "3f798638-47b0-4893-b76c-94d70e457380"

def get_last_planner_content(cid):
    transcript_path = f"/Users/deepakbagada/.gemini/antigravity-cli/brain/{cid}/.system_generated/logs/transcript_full.jsonl"
    with open(transcript_path, 'r', encoding='utf-8') as f:
        lines = f.readlines()
    for line in reversed(lines):
        data = json.loads(line)
        if data.get('type') == 'PLANNER_RESPONSE':
            return data.get('content', '')
    return ""

def parse_json_from_text(text):
    start = text.find('```json')
    if start != -1:
        start += 7
        end = text.rfind('```')
        text = text[start:end].strip()
    elif text.find('[') != -1:
        start = text.find('[')
        end = text.rfind(']') + 1
        text = text[start:end].strip()
    return json.loads(text, strict=False)

workflows = parse_json_from_text(get_last_planner_content(workflow_cid))
mcp_tools = parse_json_from_text(get_last_planner_content(mcp_cid))
blogs = parse_json_from_text(get_last_planner_content(blog_cid))

print(f"Loaded {len(workflows)} workflows, {len(mcp_tools)} MCP tools, {len(blogs)} blogs.")

combined = []
memory_entries = []

for item in workflows + mcp_tools + blogs:
    title = item.get("title")
    slug = item.get("slug")
    summary = item.get("summary", item.get("deck", "High-intent AI technical dispatch."))
    category_id = item.get("category_id", 1)
    
    dispatch = {
        "category_id": category_id,
        "author_id": 1,
        "title": title,
        "slug": slug,
        "deck": summary,
        "ai_summary": summary,
        "content": item.get("content"),
        "excerpt": summary,
        "featured_image": item.get("featured_image", "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80"),
        "reading_time": 10,
        "key_takeaways": [
            "Production-ready architecture blueprint and execution guide.",
            "Real-world benchmark metrics, time savings, and API integration steps.",
            "Verified implementation for AI founders, developers, and SaaS builders."
        ],
        "faqs": [
            {
                "question": f"What is the core takeaway of {title}?",
                "answer": summary
            }
        ],
        "tier": "free",
        "status": "published",
        "published_at": "2026-08-07 07:05:00",
        "trending_score": 95.0
    }
    combined.append(dispatch)
    
    cat_name = "AI Workflows" if category_id == 1 else ("AI Tools" if category_id == 5 else "AI Blogs")
    type_name = "Workflow" if category_id == 1 else ("MCP Tool" if category_id == 5 else "Blog")
    memory_entries.append(f"| 2026-08-07 | {cat_name} | {type_name} | {title} | `{slug}` | Production Enterprise AI |")

with open('/Users/deepakbagada/personal/Daily AI world/dispatches_payload.json', 'w', encoding='utf-8') as f:
    json.dump(combined, f, indent=2)

print(f"Successfully generated dispatches_payload.json with {len(combined)} items.")

memory_text = "\n".join(memory_entries) + "\n"

for memory_path in [
    '/Users/deepakbagada/.gemini/config/skills/dailyaiworld/memory.md',
    '/Users/deepakbagada/personal/Daily AI world/memory.md'
]:
    with open(memory_path, 'a', encoding='utf-8') as f:
        f.write(memory_text)

print("Updated memory.md files successfully.")
