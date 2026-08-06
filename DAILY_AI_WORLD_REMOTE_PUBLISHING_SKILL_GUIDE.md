# Daily AI World — Remote Content Publishing Skill & API Guide

## Overview
This skill & API guide enables external AI tools (**Antigravity**, **OpenCode**, **Codex CLI**, or custom python scripts running on any device) to research high-intent AI topics, format 1,200+ to 3,500+ word dispatches, and push them directly into both **Local MySQL** and the live **Hostinger Web Hosting (`public_html`) Remote MySQL Database** (`dailyaiworld.tech`).

---

## 🎯 Target Dispatch Mix (8 Total per Execution)

Every content generation run produces **8 fresh dispatches**:

| Dispatch Type | Quantity | Target Category | URL Prefix | Minimum Word Count | Mandatory Features |
|---|---|---|---|---|---|
| **AI Workflows & Blueprints** | 3 | `AI Workflows` (ID `1`) | `/workflow/{slug}` | **1,200+ to 3,500+ words** | ASCII/Mermaid Architecture Diagram, Multi-File Code Blocks (`.env`, `schemas.py`, `tools.py`, `graph.py`, `main.py`), Retry & Resilience Rules, Internal Links, AEO FAQs |
| **MCP Directory Tools** | 2 | `AI Tools` (ID `5`) | `/mcp-directory/{slug}` | **1,200+ words** | Full TypeScript/Python SDK Server Code, `inputSchema` Zod/JSON Definitions, `mcpServers` Config for Cursor/Claude Desktop, OAuth 2.0 Security Guide, Internal Links, AEO FAQs |
| **AI Blogs & Technical Insights** | 3 | `Coding` (ID `3`) / `LLMs` (ID `10`) | `/blogs/{slug}` | **1,200+ words** | Benchmark Comparison Tables, Financial ROI / Unit Economics, E-E-A-T Byline ("By Deepak Bagada, CEO at SaaSNext"), Code Snippets, Internal Links, AEO FAQs |

---

## 📡 Live API Endpoints & Secret Credentials

### Endpoint A: Standalone Public_HTML Endpoint (Recommended for Hostinger)
- **URL**: `https://dailyaiworld.tech/api_publish.php`
- **Method**: `POST`
- **Header**:
  ```http
  Authorization: Bearer DailyAI_Publish_Secret_2026_Secure_Token_X98
  Content-Type: application/json
  Accept: application/json
  ```

### Endpoint B: Laravel Sanctum Endpoint
- **URL**: `https://dailyaiworld.tech/api/v1/articles/publish`
- **Method**: `POST`
- **Header**:
  ```http
  Authorization: Bearer 1|LTcQEU0WkzEC45K6MIpQPMZUXAwU4IofapUyS1oEe8f25ca4
  Content-Type: application/json
  Accept: application/json
  ```

---

## 🚀 JSON Payload Structure

```json
{
  "title": "Building Autonomous AI Workflows with LangGraph & Hostinger Dual DB",
  "deck": "Step-by-step production blueprint for orchestrating multi-agent workflows with remote MySQL sync.",
  "content": "<h2>Overview</h2><p>By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.</p><p>Full markdown or HTML article content goes here...</p>",
  "type": "workflow",
  "category_id": 1,
  "tier": "Deep Dive",
  "key_takeaways": [
    "High-intent AI agent orchestration blueprint",
    "Sub-100ms response latency with dual DB sync",
    "Full multi-file python production code"
  ],
  "faqs": [
    {
      "question": "How to deploy this workflow on Hostinger public_html?",
      "answer": "Use the provided standalone PHP API bridge to trigger direct database inserts."
    }
  ]
}
```

---

## 🐍 Python Client Script (`publish_remote_article.py`)

Save and run this script on any remote laptop or inside Antigravity / OpenCode:

```python
import requests
import json
import sys
import os

API_URL = os.getenv("DAILY_AI_API_URL", "https://dailyaiworld.tech/api_publish.php")
API_TOKEN = os.getenv("DAILY_AI_API_TOKEN", "DailyAI_Publish_Secret_2026_Secure_Token_X98")

def publish_article(title, deck, content, category_id=1, article_type="blog", tier="Deep Dive", key_takeaways=None, faqs=None):
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
        "key_takeaways": key_takeaways or ["High Intent AI Content", "Instant Live Hostinger Sync"],
        "faqs": faqs or [
            {"question": "How is this published?", "answer": "Published remotely via Antigravity API."}
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
        print(f"[ERROR] Failed ({response.status_code}): {response.text}")

if __name__ == "__main__":
    sample_title = "Remote AI Publishing Test via Antigravity API"
    sample_deck = "Testing direct live site publishing using Hostinger API bridge."
    sample_content = "<h2>Introduction</h2><p>By Deepak Bagada, CEO at SaaSNext.</p><p>This article was published remotely.</p>"
    
    publish_article(sample_title, sample_deck, sample_content, article_type="workflow")
```

---

## 💻 Quick Terminal cURL Command

```bash
curl -X POST https://dailyaiworld.tech/api_publish.php \
  -H "Authorization: Bearer DailyAI_Publish_Secret_2026_Secure_Token_X98" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Remote cURL Publish Test",
    "deck": "Testing direct publishing to live website.",
    "content": "<h2>Direct Remote Insert</h2><p>Published via cURL command.</p>",
    "type": "mcp",
    "category_id": 5
  }'
```
