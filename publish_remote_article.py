import requests
import json
import sys
import os

API_URL = os.getenv("DAILY_AI_API_URL", "https://dailyaiworld.tech/api/v1/articles/publish")
API_TOKEN = os.getenv("DAILY_AI_API_TOKEN", "")

def publish_article(title, deck, content, category_id=1, article_type="blog", tier="Deep Dive", key_takeaways=None, faqs=None):
    if not API_TOKEN:
        print("[ERROR] Please set DAILY_AI_API_TOKEN environment variable.")
        sys.exit(1)

    headers = {
        "Authorization": f"Bearer {API_TOKEN}",
        "Content-Type": "application/json",
        "Accept": "application/json"
    }

    payload = {
        "title": title,
        "deck": deck,
        "content": content,
        "category_id": category_id,
        "type": article_type,
        "tier": tier,
        "key_takeaways": key_takeaways or ["High Intent AI Workflow", "Instant Dual DB Sync"],
        "faqs": faqs or [
            {"question": "How to deploy this workflow?", "answer": "Follow the step-by-step blueprint provided above."}
        ]
    }

    print(f"[INFO] Publishing '{title}' to {API_URL}...")
    response = requests.post(API_URL, headers=headers, json=payload)

    if response.status_code == 201:
        data = response.json()
        print("[SUCCESS] Article Published!")
        print(f"Slug: {data['data']['slug']}")
        print(f"Live URL: {data['data']['live_url']}")
    else:
        print(f"[ERROR] Failed to publish ({response.status_code}): {response.text}")

if __name__ == "__main__":
    # Test sample execution
    sample_title = "Building Autonomous AI Agents with LangGraph & Hostinger Dual DB"
    sample_deck = "Step-by-step production blueprint for orchestrating multi-agent workflows with remote MySQL sync."
    sample_content = """
    <h2>Introduction</h2>
    <p>By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.</p>
    <p>Learn how to connect Antigravity, OpenCode, and Codex CLI to your live Laravel platform using our remote REST API.</p>
    """
    
    if len(sys.argv) > 1 and sys.argv[1] == "--test":
        publish_article(sample_title, sample_deck, sample_content, article_type="workflow")
    else:
        print("Usage: DAILY_AI_API_TOKEN='your_token' python publish_remote_article.py --test")
