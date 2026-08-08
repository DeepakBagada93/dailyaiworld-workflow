import json

def extract_json(transcript_path):
    with open(transcript_path) as f:
        for line in f:
            data = json.loads(line)
            if data.get('type') == 'PLANNER_RESPONSE':
                content = data.get('content', '')
                if '```json' in content:
                    start = content.find('```json') + 7
                    end = content.rfind('```')
                    json_str = content[start:end].strip()
                    try:
                        return json.loads(json_str)
                    except Exception as e:
                        print(f"Error parsing json from {transcript_path}: {e}")
    return None

wf = extract_json('/Users/deepakbagada/.gemini/antigravity-cli/brain/4a556823-2335-49d5-8e8b-1367fa4d2efd/.system_generated/logs/transcript_full.jsonl')
mcp = extract_json('/Users/deepakbagada/.gemini/antigravity-cli/brain/d7572456-984d-4ca2-9965-2c06f74a6745/.system_generated/logs/transcript_full.jsonl')
blogs = extract_json('/Users/deepakbagada/.gemini/antigravity-cli/brain/adc39dea-b1db-499a-8e7c-018adb8ef9a0/.system_generated/logs/transcript_full.jsonl')

print(f"Workflows: {len(wf) if wf else 0}")
print(f"MCP Tools: {len(mcp) if mcp else 0}")
print(f"Blogs: {len(blogs) if blogs else 0}")

if wf and mcp and blogs:
    all_dispatches = wf + mcp + blogs
    with open('/Users/deepakbagada/personal/Daily AI world/dispatches_payload.json', 'w') as f:
        json.dump(all_dispatches, f, indent=2)
    print(f"Successfully created dispatches_payload.json with {len(all_dispatches)} dispatches!")
