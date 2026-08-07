---
name: dailyaiworld
description: >
  Researches high-intent, viral, and trending AI topics to publish 1,200+ to 3,500+ word AI Workflows,
  MCP Tool Guides, and AI Technical Blogs for Daily AI World using 4 concurrent subagents (3 Writers + 1 SEO/AEO/HEO Auditor).
  Audits content for pure Markdown syntax, E-E-A-T bylines, internal links, and AEO FAQs before database insertion.
  Publishes directly into both local MySQL and live Hostinger Remote MySQL databases.
  Activate when the user asks to generate high-intent articles, publish workflows, add MCP tools,
  run daily content dispatches, or publish viral tech content for Daily AI World.
---

# Daily AI World — Master High-Intent Content & Dual-DB Publishing Skill (with SEO/AEO/HEO Quality Auditor)

## Overview
This skill automates high-intent trend research, high-CTR title/deck framing, **in-depth 1,200+ word technical dispatches**, internal/external link optimization, full SEO metadata generation, anti-duplication tracking via `memory.md`, **token-efficient automated quality auditing**, and direct dual-database publishing (Local MySQL + Live Hostinger Remote MySQL) using a **4-Subagent Architecture** (3 Writers + 1 Quality Auditor).

---

## 🎯 Target Dispatch Mix & 4-Subagent Architecture

Every execution produces **11 fresh dispatches** validated by the Auditor subagent before publishing:

| Dispatch Type | Subagent Name | Quantity | Target Category | URL Prefix | Minimum Word Count | Mandatory Features & Mandatory SEO Metadata |
|---|---|---|---|---|---|---|
| **AI Workflows & Blueprints** | `workflow-writer` | 3 | `AI Workflows` (ID `1`) | `/workflow/{slug}` | **1,200+ to 3,500+ words** | ASCII/Mermaid Architecture Diagram, Multi-File Code Blocks (`.env`, `schemas.py`, `tools.py`, `graph.py`, `main.py`), Retry Rules, Internal Links to https://dailyaiworld.com/, AEO FAQs + SEO Meta Info |
| **MCP Directory Tools** | `mcp-writer` | 2 | `AI Tools` (ID `5`) | `/mcp-directory/{slug}` | **1,200+ words** | Full TypeScript/Python SDK Server Code, `inputSchema` JSON Definitions, `mcpServers` Config, OAuth 2.0 Security Guide, Internal Links to https://dailyaiworld.com/, AEO FAQs + SEO Meta Info |
| **AI Blogs & Technical Insights** | `blog-writer` | 6 | `Coding` (ID `3`) / `LLMs` (ID `10`) | `/blogs/{slug}` | **1,200+ words** | Benchmark Comparison Tables, Financial ROI / Unit Economics, E-E-A-T Byline ("By Deepak Bagada, CEO at SaaSNext"), Code Snippets, Internal Links to https://dailyaiworld.com/, AEO FAQs + SEO Meta Info |
| **Quality & SEO/AEO Auditor** | `seo-auditor` | Audit All | All Dispatches | Validation Gate | N/A | **Validates zero raw HTML tags, pure Markdown format, internal link domain validation, E-E-A-T bylines, FAQ question/answer keys, and word count before DB push.** |

---

## 🛡️ Strict Quality & SEO/AEO/HEO Audit Rules (Gatekeeper)

Before any dispatch payload is pushed to local or live databases, `seo-auditor` evaluates each dispatch against **5 Mandatory Verification Gates**:

1. **Pure Markdown Format Check (Zero Raw HTML)**:
   - Must NOT contain raw HTML tags like `<h2>`, `<p>`, `<pre>`, `<code>`. Must use clean Markdown (`##`, `###`, ````python`, `| tables |`).
2. **Internal Link Validation**:
   - Must contain live contextual internal links to `https://dailyaiworld.com/workflows`, `https://dailyaiworld.com/mcp-directory`, or `https://dailyaiworld.com/latest-ai-news`. NEVER use `localhost`, `127.0.0.1`, or relative dummy links.
3. **E-E-A-T & Practitioner Byline Check**:
   - Must include: `**By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.**`
4. **FAQ Structure Verification**:
   - `faqs` array items must use standardized keys: `{"question": "...", "answer": "..."}`.
5. **Token Efficiency Guarantee**:
   - Use programmatic validation scripts first. The AI subagent is ONLY invoked if formatting corrections are required, avoiding unnecessary token consumption.

---

## 🏷️ Mandatory SEO & Meta Information Standard

Every generated dispatch object MUST contain complete, optimized SEO meta attributes:

1. **`title`**: Catchy, high-CTR article headline (50-65 chars).
2. **`seo_title`**: SEO-optimized meta title ending with `| Daily AI World`.
3. **`meta_description`**: Compelling, keyword-rich summary (140-160 chars) designed for maximum Search Engine CTR.
4. **`seo_keywords`**: Comma-separated list of 5-8 primary & LSI search keywords.
5. **`deck` / `ai_summary` / `excerpt`**: Concise executive briefing for card feeds and AI search engines.
6. **`featured_image` / `og_image`**: High-quality 1200x630 visual asset URL (`https://dailyaiworld.com/images/...` or Unsplash tech visual). MUST be a fully qualified, valid URL starting with `https://` (never use relative filenames or relative paths).

---

## 🧠 Anti-Duplication Memory System (`memory.md`)

Before generating any content:
1. **Check `memory.md`**: Read `memory.md` in the workspace or skill folder.
2. **Ensure Topic Uniqueness**: Compare target titles, slugs, and technical topics against past published dispatches in `memory.md`. **DO NOT repeat any topic or slug.**
3. **Log New Dispatches**: After publishing, append newly generated dispatches into `memory.md`.

---

## 🚀 Execution Workflow (Step-by-Step)

When invoked, the agent MUST follow these 5 steps:

### Step 1: Check `memory.md` & Research August 2026 Trending Topics
Inspect `memory.md` to avoid duplicate coverage, then identify 11 fresh, high-intent AI topics.

### Step 2: Launch 3 Parallel Writer Subagents via `invoke_subagent`
Spawn `workflow-writer`, `mcp-writer`, and `blog-writer` concurrently to generate pure Markdown dispatches.

### Step 3: Run Automated Token-Efficient Auditor Script (`audit_dispatches.py`)
Run the programmatic auditor script to validate formatting instantly without consuming extra LLM tokens:

```bash
python3 audit_dispatches.py
```

If any article fails Markdown checks or FAQ key structures, launch the `seo-auditor` subagent (`Model="flash"`) to rewrite ONLY the invalid articles.

### Step 4: Combine Outputs & Update `memory.md`
Merge the validated JSON dispatch objects into `dispatches_payload.json` and append the new titles to `memory.md`.

### Step 5: Run Dual-DB Publisher Script
Execute the dual database publisher script:

```bash
php publish_dual_db.php
```

This script will:
1. Generate unique SEO/AEO-optimized slugs (`Article::generateSeoSlug()`).
2. Insert/Update all 11 articles in **Local MySQL Database** (`daily_ai_world`).
3. Push all 11 articles directly into **Live Hostinger Remote MySQL Database** (`193.203.184.64:3306`, DB: `u775719140_dailyai`).
4. Clear compiled view caches (`php artisan view:clear`) for immediate live visibility.

---

## 🔐 Database Credentials Reference (Hostinger Live DB)

- **Host IP / Server**: `193.203.184.64` / `srv1334.hstgr.io`
- **Port**: `3306`
- **Database**: `u775719140_dailyai`
- **Username**: `u775719140_admin`
- **Password**: `Dailyaiworld@3093`
- **Valid `tier` Enum Values**: `'Breaking'`, `'Deep Dive'`, `'Founder Story'`, `'Research Breakdown'`, `'Briefing'` (Default: `'Deep Dive'`).
