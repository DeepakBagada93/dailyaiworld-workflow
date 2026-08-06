---
name: dailyaiworld
description: >
  Researches high-intent, viral, and trending AI topics to publish 1,200+ to 3,500+ word AI Workflows,
  MCP Tool Guides, and AI Technical Blogs for Daily AI World using 3 concurrent subagents.
  Generates 3 AI Workflows, 2 MCP Directory Tools, and 3 AI Blogs (8 total dispatches) with contextual internal links,
  Google-compliant rel="nofollow noopener noreferrer" external links, multi-file code blueprints, ASCII/Mermaid flow diagrams,
  and AEO/GEO FAQ sections. Publishes directly into both local MySQL and live Hostinger Remote MySQL databases.
  Activate when the user asks to generate high-intent articles, publish workflows, add MCP tools,
  run daily content dispatches, or publish viral tech content for Daily AI World.
---

# Daily AI World — Master High-Intent Content & Dual-DB Publishing Skill

## Overview
This skill automates high-intent trend research, high-CTR title/deck framing, **in-depth 1,200+ word technical dispatches**, internal/external link optimization, and direct dual-database publishing (Local MySQL + Live Hostinger Remote MySQL) using a **3-Subagent Parallel Architecture**.

---

## 🎯 Target Dispatch Mix (8 Total per Execution)

Every execution produces **8 fresh dispatches**:

| Dispatch Type | Subagent Name | Quantity | Target Category | URL Prefix | Minimum Word Count | Mandatory Features |
|---|---|---|---|---|---|---|
| **AI Workflows & Blueprints** | `workflow-writer` | 3 | `AI Workflows` (ID `1`) | `/workflow/{slug}` | **1,200+ to 3,500+ words** | ASCII/Mermaid Architecture Diagram, Multi-File Code Blocks (`.env`, `schemas.py`, `tools.py`, `graph.py`, `main.py`), Retry & Resilience Rules, Internal Links, AEO FAQs |
| **MCP Directory Tools** | `mcp-writer` | 2 | `AI Tools` (ID `5`) | `/mcp-directory/{slug}` | **1,200+ words** | Full TypeScript/Python SDK Server Code, `inputSchema` Zod/JSON Definitions, `mcpServers` Config for Cursor/Claude Desktop, OAuth 2.0 Security Guide, Internal Links, AEO FAQs |
| **AI Blogs & Technical Insights** | `blog-writer` | 3 | `Coding` (ID `3`) / `LLMs` (ID `10`) | `/blogs/{slug}` | **1,200+ words** | Benchmark Comparison Tables, Financial ROI / Unit Economics, E-E-A-T Byline ("By Deepak Bagada, CEO at SaaSNext"), Code Snippets, Internal Links, AEO FAQs |

---

## 🏛️ Google E-E-A-T & AEO/GEO Standard

Google rewards **Experience, Expertise, Authoritativeness, and Trustworthiness (E-E-A-T)**. All generated articles MUST adhere to this strict structure:

### 1. Semantic Heading Hierarchy (`<h1>` - `<h6>`):
- `<h1>`: Main Article Title (Single instance)
- `<h2>`: Major Sections (Architecture, Setup, Implementation, Security, Testing, FAQs)
- `<h3>`: Sub-topics, Code Modules, and Specific Framework Connectors
- `<h4>`: Parameter Configurations, Utility Functions, or Schema Attributes
- `<h5>` & `<h6>`: Advanced Edge Cases / Debugging Notes

### 2. Practitioner Byline & Internal Links:
- Include byline: *"By Deepak Bagada, CEO at SaaSNext & Principal AI Architect."*
- Include real production metrics (e.g., sub-100ms latency, 65% API cost reduction, 99.4% SLA uptime).
- Add contextual internal links:
  - `<a href="https://dailyaiworld.tech/workflows">AI Workflows Library</a>`
  - `<a href="https://dailyaiworld.tech/mcp-directory">MCP Tools Directory</a>`
  - `<a href="https://dailyaiworld.tech/latest-ai-news">Latest AI News</a>`
- Add external citations with `<a href="..." rel="nofollow noopener noreferrer">`.

---

## 🚀 Execution Workflow (Step-by-Step)

When invoked, the agent MUST follow these 4 steps:

### Step 1: Research August 2026 Trending Topics
Identify 8 high-intent, viral topics currently trending in AI:
- **3 Workflows**: Agentic orchestration (LangGraph, AutoGen, CrewAI, n8n, Qdrant, LlamaIndex, AutoGPT).
- **2 MCP Tools**: FastMCP TypeScript SDK, Supabase Vector, PostgreSQL, GitHub MCP, Brave Search MCP, Custom MCP tools for Cursor & Claude Desktop.
- **3 AI Blogs**: Open-weight reasoning models (DeepSeek-R2, Claude 3.7, Gemini 2.5), AI SaaS pricing models, token unit economics.

### Step 2: Launch 3 Parallel Subagents via `invoke_subagent`

Spawn 3 subagents concurrently:
1. `workflow-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "AI Workflows Writer",
     "Model": "pro",
     "Prompt": "Write 3 IN-DEPTH AI Workflows (Minimum 1,200+ words each). Include ASCII diagrams, 5 multi-file code blocks (.env, schemas.py, tools.py, graph.py, main.py), retry strategies, internal links to /workflows and /mcp-directory, and 3 AEO Q&A pairs."
   }
   ```
2. `mcp-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "MCP Tools Writer",
     "Model": "pro",
     "Prompt": "Write 2 IN-DEPTH MCP Directory Tool Guides (Minimum 1,200+ words each). Include full TypeScript/Python server code, inputSchema JSON definitions, mcpServers config block, OAuth security guide, internal links to /mcp-directory and /workflows, and 3 AEO Q&A pairs."
   }
   ```
3. `blog-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "AI Blogs Writer",
     "Model": "pro",
     "Prompt": "Write 3 IN-DEPTH AI Technical Blogs (Minimum 1,200+ words each). Include benchmark comparison tables, E-E-A-T byline ('By Deepak Bagada, CEO at SaaSNext'), code snippets, internal links to /latest-ai-news and /workflows, and 3 AEO Q&A pairs."
   }
   ```

### Step 3: Combine Outputs into `dispatches_payload.json`
Merge the 8 JSON dispatch objects returned by the subagents into `dispatches_payload.json` in the root workspace directory.

### Step 4: Run Dual-DB Publisher Script / Trigger Remote REST API
Execute the dual database publisher script:

```bash
php publish_dual_db.php
```

Or trigger the public remote API:
```bash
curl -X POST https://dailyaiworld.tech/api_publish.php \
  -H "Authorization: Bearer DailyAI_Publish_Secret_2026_Secure_Token_X98" \
  -H "Content-Type: application/json" \
  -d @dispatches_payload.json
```

---

## 🔐 Database & API Secret Credentials Reference

- **Hostinger Server IP**: `193.203.184.64` / `srv1334.hstgr.io`
- **Port**: `3306`
- **Database**: `u775719140_dailyai`
- **Username**: `u775719140_admin`
- **Password**: `Dailyaiworld@3093`
- **Public HTML API Token**: `DailyAI_Publish_Secret_2026_Secure_Token_X98`
- **Sanctum API Token**: `1|LTcQEU0WkzEC45K6MIpQPMZUXAwU4IofapUyS1oEe8f25ca4`
