import json

# 1. Load Workflows from Subagent 1
with open('/Users/deepakbagada/.gemini/antigravity-cli/brain/6c41a6a9-e326-4058-96f5-f8366bd68fc5/scratch/workflows.json', 'r') as f:
    workflows = json.load(f)

# 2. Load MCP Tools from Subagent 2
with open('/Users/deepakbagada/personal/Daily AI world/mcp_payload.json', 'r') as f:
    mcp_tools = json.load(f)

# 3. Read Blog transcript from Subagent 3
with open('/Users/deepakbagada/.gemini/antigravity-cli/brain/45a9c8ac-0f5a-4429-a00b-e5c5afb57365/.system_generated/logs/transcript_full.jsonl', 'r') as f:
    lines = f.readlines()

blog_json_str = None
for line in lines:
    data = json.loads(line)
    if data.get('type') == 'PLANNER_RESPONSE':
        content = data.get('content', '')
        if 'DeepSeek-R2' in content:
            # Extract JSON block
            start = content.find('```json')
            if start != -1:
                start += 7
                end = content.rfind('```')
                blog_json_str = content[start:end].strip()
            else:
                blog_json_str = content.strip()

blogs = json.loads(blog_json_str)

# Ensure standardized fields across all dispatches
combined = []

for item in workflows + mcp_tools + blogs:
    dispatch = {
        "category_id": item.get("category_id", 1),
        "author_id": 1,
        "title": item.get("title"),
        "deck": item.get("deck"),
        "ai_summary": item.get("ai_summary", item.get("deck")),
        "content": item.get("content"),
        "excerpt": item.get("deck"),
        "featured_image": item.get("featured_image", "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80"),
        "reading_time": item.get("reading_time", 8),
        "key_takeaways": item.get("key_takeaways", [
            "Production-ready architecture blueprint and execution guide.",
            "Real-world benchmark metrics, time savings, and API integration steps.",
            "Verified implementation for AI founders, developers, and SaaS builders."
        ]),
        "faqs": item.get("faqs", [
            {
                "question": f"What is the primary takeaway of {item.get('title')}?",
                "answer": item.get("deck")
            }
        ]),
        "tier": "free",
        "status": "published",
        "published_at": "2026-08-05 20:00:00",
        "trending_score": 85.0
    }
    combined.append(dispatch)

with open('/Users/deepakbagada/personal/Daily AI world/dispatches_payload.json', 'w') as f:
    json.dump(combined, f, indent=2)

print(f"Successfully combined {len(combined)} dispatches into dispatches_payload.json!")
