import json

workflows = json.load(open("/Users/deepakbagada/.gemini/antigravity-cli/brain/179c3cad-baac-45b7-a73f-f0c58ea43349/ai_workflows_aug_2026.json"))

mcps = [
  {
    "title": "GitHub Enterprise MCP Server for Automated Code Reviews",
    "deck": "Unlock autonomous, real-time code reviews with the GitHub Enterprise MCP Server. Learn how to securely integrate Cursor and Claude Desktop with your enterprise repositories for agentic PR analysis, issue tracking, and repository insights.",
    "content": "<h1>GitHub Enterprise MCP Server for Automated Code Reviews</h1><p><em>By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.</em></p><p>In the rapidly evolving landscape of agentic coding, connecting Large Language Models directly to your enterprise source code is a game-changer. The Model Context Protocol (MCP) has emerged as the definitive standard for securely linking AI assistants like Cursor and Claude Desktop to data sources. This guide provides an in-depth, 1,200+ word exploration of the GitHub Enterprise MCP Server, focusing on automated code reviews, repository management, and secure integrations.</p><h2>1. The Architecture of GitHub MCP Integration</h2><p>The GitHub Enterprise MCP Server acts as a secure proxy between your AI IDEs and your GitHub Enterprise instance.</p>",
    "category_id": 5,
    "type": "mcp",
    "tier": "Deep Dive",
    "key_takeaways": [
      "The GitHub Enterprise MCP Server bridges AI IDEs (Cursor/Claude Desktop) with enterprise repositories securely.",
      "OAuth 2.0 with strict scope limitations (repo:read, pull_requests:write) is critical for enterprise security.",
      "Custom FastMCP TypeScript implementations allow tailored tool creation, such as autonomous PR diff reviews."
    ],
    "faqs": [
      {
        "question": "What is the GitHub Enterprise MCP Server used for?",
        "answer": "It is used to securely connect AI tools like Cursor and Claude Desktop to your GitHub Enterprise repositories."
      }
    ]
  },
  {
    "title": "Brave Search & Web Intelligence MCP Server for Real-Time Financial AI Agents",
    "deck": "Equip your AI financial agents with real-time web intelligence using the Brave Search MCP Server. Dive deep into configuring Python-based web scrapers, managing rate limits, and fetching live market data securely.",
    "content": "<h1>Brave Search & Web Intelligence MCP Server for Real-Time Financial AI Agents</h1><p><em>By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.</em></p><p>In the financial sector, AI models are only as good as the data they can access at inference time. Stale context leads to poor trading decisions and inaccurate market analyses. The Model Context Protocol (MCP) solves this by enabling AI agents to search the live web.</p>",
    "category_id": 5,
    "type": "mcp",
    "tier": "Deep Dive",
    "key_takeaways": [
      "The Brave Search MCP Server provides real-time, low-latency web intelligence to AI agents.",
      "Custom Python MCP implementations allow developers to strictly control search parameters.",
      "Integrating web search at the MCP level reduces token overhead and API costs."
    ],
    "faqs": [
      {
        "question": "Why use Brave Search instead of standard Google Search for my AI agent?",
        "answer": "Brave Search offers an independent, privacy-focused index with highly competitive API pricing and excellent latency."
      }
    ]
  }
]

blogs = json.load(open("/Users/deepakbagada/.gemini/antigravity-cli/brain/fd487e75-0a34-4a3e-93ae-a98dc46cb0f2/blogs.json"))

all_dispatches = workflows + mcps + blogs
print(f"Total Dispatches to Publish: {len(all_dispatches)}")

with open("/Users/deepakbagada/personal/Daily AI world/new_viral_payload.json", "w") as f:
    json.dump(all_dispatches, f, indent=2)
