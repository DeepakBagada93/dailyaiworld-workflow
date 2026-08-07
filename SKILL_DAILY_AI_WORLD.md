---
name: dailyaiworld
description: >
  Researches high-intent, viral, and trending AI topics to publish 1,200+ to 3,500+ word AI Workflows,
  MCP Tool Guides, and AI Technical Blogs for Daily AI World using 3 concurrent subagents.
  Generates 3 AI Workflows, 2 MCP Directory Tools, and 6 AI Blogs (11 total dispatches per execution) with full SEO meta tags
  (SEO Title, Meta Description, SEO Keywords, OpenGraph Image, Author Byline with X Profile),
  contextual internal links to https://dailyaiworld.com/, Google-compliant rel="nofollow noopener noreferrer" external links,
  multi-file code blueprints, ASCII/Mermaid flow diagrams, and AEO/GEO FAQ sections.
  Publishes directly into both local MySQL and live Hostinger Remote MySQL databases.
  Activate when the user asks to generate high-intent articles, publish workflows, add MCP tools,
  run daily content dispatches, or publish viral tech content for Daily AI World.
---

# Daily AI World — Master High-Intent Content & Dual-DB Publishing Skill

## Overview
This skill automates high-intent trend research, high-CTR title/deck framing, **in-depth 1,200+ word technical dispatches**, internal/external link optimization, full SEO metadata generation (SEO Title, Meta Description, Keywords, Social OpenGraph tags), anti-duplication tracking via `memory.md`, and direct dual-database publishing (Local MySQL + Live Hostinger Remote MySQL) using a **3-Subagent Parallel Architecture**.

---

## 🎯 Target Dispatch Mix (11 Total per Execution)

Every execution produces **11 fresh dispatches**:

| Dispatch Type | Subagent Name | Quantity | Target Category | URL Prefix | Minimum Word Count | Mandatory Features & Mandatory SEO Metadata |
|---|---|---|---|---|---|---|
| **AI Workflows & Blueprints** | `workflow-writer` | 3 | `AI Workflows` (ID `1`) | `/workflow/{slug}` | **1,200+ to 3,500+ words** | ASCII/Mermaid Architecture Diagram, Multi-File Code Blocks (`.env`, `schemas.py`, `tools.py`, `graph.py`, `main.py`), Retry & Resilience Rules, Internal Links to https://dailyaiworld.com/, AEO FAQs + **SEO Meta Info** (SEO Title, Meta Description, Focus Keywords, OG Image, Author X Byline) |
| **MCP Directory Tools** | `mcp-writer` | 2 | `AI Tools` (ID `5`) | `/mcp-directory/{slug}` | **1,200+ words** | Full TypeScript/Python SDK Server Code, `inputSchema` Zod/JSON Definitions, `mcpServers` Config for Cursor/Claude Desktop, OAuth 2.0 Security Guide, Internal Links to https://dailyaiworld.com/, AEO FAQs + **SEO Meta Info** (SEO Title, Meta Description, Focus Keywords, OG Image, Author X Byline) |
| **AI Blogs & Technical Insights** | `blog-writer` | 6 | `Coding` (ID `3`) / `LLMs` (ID `10`) | `/blogs/{slug}` | **1,200+ words** | Benchmark Comparison Tables, Financial ROI / Unit Economics, E-E-A-T Byline ("By Deepak Bagada, CEO at SaaSNext"), Code Snippets, Internal Links to https://dailyaiworld.com/, AEO FAQs + **SEO Meta Info** (SEO Title, Meta Description, Focus Keywords, OG Image, Author X Byline) |

---

## 🏷️ Mandatory SEO & Meta Information Standard

Every generated dispatch object MUST contain complete, optimized SEO meta attributes:

1. **`title`**: Catchy, high-CTR article headline (50-65 chars).
2. **`seo_title`**: SEO-optimized meta title ending with `| Daily AI World`.
3. **`meta_description`**: Compelling, keyword-rich summary (140-160 chars) designed for maximum Search Engine CTR.
4. **`seo_keywords`**: Comma-separated list of 5-8 primary & LSI search keywords.
5. **`deck` / `ai_summary` / `excerpt`**: Concise executive briefing for card feeds and AI search engines.
6. **`featured_image` / `og_image`**: High-quality 1200x630 visual asset URL (`https://dailyaiworld.com/images/...` or Unsplash tech visual).
7. **`author_byline`**: Explicit linked author attribution:
   `By <a href="https://x.com/deeepakbagada" rel="nofollow noopener noreferrer">Deepak Bagada</a>, CEO at SaaSNext & Principal AI Architect.`

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
- Include linked byline: *"By <a href="https://x.com/deeepakbagada" rel="nofollow noopener noreferrer">Deepak Bagada</a>, CEO at SaaSNext & Principal AI Architect."*
- Include real production metrics (e.g., sub-100ms latency, 65% API cost reduction, 99.4% SLA uptime).
- Add contextual live internal links using domain `https://dailyaiworld.com/` (NEVER use `localhost` or local IPs):
  - `<a href="https://dailyaiworld.com/workflows">AI Workflows Library</a>`
  - `<a href="https://dailyaiworld.com/mcp-directory">MCP Tools Directory</a>`
  - `<a href="https://dailyaiworld.com/latest-ai-news">Latest AI News</a>`
- Add external citations with `<a href="..." rel="nofollow noopener noreferrer">`.

---

## 🧠 Anti-Duplication Memory System (`memory.md`)

Before generating any content:
1. **Check `memory.md`**: Read `memory.md` in the skill folder (`/Users/deepakbagada/.gemini/config/skills/dailyaiworld/memory.md`) or root workspace (`/Users/deepakbagada/personal/Daily AI world/memory.md`).
2. **Ensure Topic Uniqueness**: Compare target titles, slugs, and technical topics against past published dispatches in `memory.md`. **DO NOT repeat any topic or slug.**
3. **Log New Dispatches**: After publishing, append newly generated dispatches into `memory.md` with date, category, type, title, slug, and core tech.

---

## 🚀 Execution Workflow (Step-by-Step)

When invoked, the agent MUST follow these 4 steps:

### Step 1: Check `memory.md` & Research August 2026 Trending Topics
First inspect `memory.md` to avoid duplicate coverage. Then identify 11 fresh, high-intent, viral topics currently trending in AI:
- **3 Workflows**: Agentic orchestration (LangGraph, AutoGen, CrewAI, n8n, Qdrant, LlamaIndex, AutoGPT).
- **2 MCP Tools**: FastMCP TypeScript SDK, Supabase Vector, PostgreSQL, GitHub MCP, Brave Search MCP, Custom MCP tools for Cursor & Claude Desktop.
- **6 AI Blogs**: Open-weight reasoning models (DeepSeek-R2, Claude 3.7, Gemini 2.5), AI SaaS pricing models, token unit economics, AI Agent SLA governance, inference optimization, vector DB benchmarks.

### Step 2: Launch 3 Parallel Subagents via `invoke_subagent`

Spawn 3 subagents concurrently:
1. `workflow-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "AI Workflows Writer",
     "Model": "pro",
     "Prompt": "Check memory.md to ensure zero repeated topics. Write 3 IN-DEPTH AI Workflows (Minimum 1,200+ words each). For each workflow include complete SEO metadata (title, seo_title, meta_description, seo_keywords, featured_image), ASCII diagrams, 5 multi-file code blocks (.env, schemas.py, tools.py, graph.py, main.py), retry strategies, internal links using live domain https://dailyaiworld.com/ (/workflows and /mcp-directory), linked author byline with X profile https://x.com/deeepakbagada, and 3 AEO Q&A pairs."
   }
   ```
2. `mcp-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "MCP Tools Writer",
     "Model": "pro",
     "Prompt": "Check memory.md to ensure zero repeated topics. Write 2 IN-DEPTH MCP Directory Tool Guides (Minimum 1,200+ words each). For each guide include complete SEO metadata (title, seo_title, meta_description, seo_keywords, featured_image), full TypeScript/Python server code, inputSchema JSON definitions, mcpServers config block, OAuth security guide, internal links using live domain https://dailyaiworld.com/ (/mcp-directory and /workflows), linked author byline with X profile https://x.com/deeepakbagada, and 3 AEO Q&A pairs."
   }
   ```
3. `blog-writer`:
   ```json
   {
     "TypeName": "self",
     "Role": "AI Blogs Writer",
     "Model": "pro",
     "Prompt": "Check memory.md to ensure zero repeated topics. Write 6 IN-DEPTH AI Technical Blogs (Minimum 1,200+ words each). For each blog include complete SEO metadata (title, seo_title, meta_description, seo_keywords, featured_image), benchmark comparison tables, E-E-A-T byline with author X profile ('By <a href=\"https://x.com/deeepakbagada\" rel=\"nofollow noopener noreferrer\">Deepak Bagada</a>, CEO at SaaSNext'), code snippets, internal links using live domain https://dailyaiworld.com/ (/latest-ai-news and /workflows), and 3 AEO Q&A pairs."
   }
   ```

### Step 3: Combine Outputs & Update `memory.md`
1. Merge the 11 JSON dispatch objects returned by the subagents into `dispatches_payload.json` in the root workspace directory. Ensure all 11 dispatches carry complete `seo_title`, `meta_description`, `seo_keywords`, and `featured_image` metadata fields.
2. Append newly generated dispatches to `memory.md`.

### Step 4: Run Dual-DB Publisher Script
Execute the dual database publisher script:

```bash
php publish_dual_db.php
```

This script will:
1. Generate unique SEO/AEO-optimized slugs (`Article::generateSeoSlug()`).
2. Insert/Update all 11 articles in the **Local MySQL Database** (`daily_ai_world`).
3. Push all 11 articles directly into the **Live Hostinger Remote MySQL Database** (`193.203.184.64:3306`, DB: `u775719140_dailyai`).
4. Clear compiled view caches (`php artisan view:clear`) for immediate live visibility.

---

## 🔐 Database Credentials Reference (Hostinger Live DB)

- **Host IP / Server**: `193.203.184.64` / `srv1334.hstgr.io`
- **Port**: `3306`
- **Database**: `u775719140_dailyai`
- **Username**: `u775719140_admin`
- **Password**: `Dailyaiworld@3093`
- **Valid `tier` Enum Values**: `'Breaking'`, `'Deep Dive'`, `'Founder Story'`, `'Research Breakdown'`, `'Briefing'` (Default: `'Deep Dive'`).
