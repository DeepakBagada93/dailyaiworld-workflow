---
name: dailyaiworld
description: >
  Universal, production-grade autonomous content publishing skill for Daily AI World (dailyaiworld.com).
  Produces 12 ultra-high-quality, high-CTR, high-E-E-A-T, and AEO-optimized technical dispatches across a
  strict 4-cycle sequential architecture (3 AI Workflows + 3 MCP Tools + 3 AI Blogs + 3 AI News).
  Strict word count constraint: 1,000 to 1,200 words per article (high density, zero fluff).
  Features dynamic live HTTP 200 internal link verification, multi-file runnable code standards,
  dual-database publishing (Local MySQL & Hostinger Live MySQL), and automated live URL validation.
  Engineered to work seamlessly with ANY CLI coding tool (Antigravity, Claude Code, Cursor CLI, Roo Code, Aider, Codex).
---

# 🌐 Daily AI World — Autonomous Content Engine v3.0

> [!IMPORTANT]  
> **CONTENT IS KING (1,000 – 1,200 WORDS)**: Daily AI World is an ultra-premium executive intelligence journal for AI founders, architects, and builders. Every article MUST be strictly between **1,000 and 1,200 words** of high-density engineering substance, runnable multi-file code, specific performance/cost metrics, and zero fluff.
> 
> **UNIVERSAL CLI COMPATIBILITY**: This skill works in any CLI coding environment. If subagents are supported (`invoke_subagent`), spawn specialized agents for each stage. If working in a single-agent or linear CLI environment (e.g. Claude Code, Cursor, Aider), execute the steps sequentially in your main context.

---

## 1. 🚀 Executive Architecture & Sequential Pipeline

The pipeline produces **12 articles per run** organized into **4 strictly sequential cycles**:

```
Cycle 1: AI Workflows (3 Articles) ──► Research ──► Write ──► Audit ──► Publish ──► Live URL Audit ──► Log
                                                                                                        │
Cycle 2: MCP Tools (3 Articles)    ──► Research ──► Write ──► Audit ──► Publish ──► Live URL Audit ──► Log
                                                                                                        │
Cycle 3: AI Blogs (3 Articles)     ──► Research ──► Write ──► Audit ──► Publish ──► Live URL Audit ──► Log
                                                                                                        │
Cycle 4: AI News (3 Articles)      ──► Research ──► Write ──► Audit ──► Publish ──► Live URL Audit ──► Final Report
```

> [!CAUTION]  
> **SEQUENTIAL RULE**: Never proceed to Cycle N+1 until Cycle N is 100% written, audited, published to Dual-DB, verified live with HTTP 200, and logged to `memory.md`.

---

## 2. 📊 Dispatch Mix & Category Routing

| Cycle | Type | Category Name | Category ID | Canonical URL Route | Strict Word Count |
|---|---|---|---|---|---|
| **Cycle 1** | **AI Workflows** | AI Workflows | `1` | `https://dailyaiworld.com/workflow/{slug}` | **1,000 – 1,200 words** |
| **Cycle 2** | **MCP Directory** | AI Tools | `5` | `https://dailyaiworld.com/mcp-directory/{slug}` | **1,000 – 1,200 words** |
| **Cycle 3** | **AI Blogs** | Coding / LLMs | `3` or `10` | `https://dailyaiworld.com/blogs/{slug}` | **1,000 – 1,200 words** |
| **Cycle 4** | **AI News** | AI News | `11` | `https://dailyaiworld.com/blogs/{slug}` | **1,000 – 1,200 words** |

---

## 3. 🧠 MANDATORY STEP 0: Anti-Duplication Protocol (`memory.md`)

Before generating ANY topic, the agent MUST read both memory files to prevent topic and slug cannibalization:
- Local Workspace: `/Users/deepakbagada/personal/Daily AI world/memory.md`
- Gemini Config: `/Users/deepakbagada/.gemini/config/skills/dailyaiworld/memory.md`

### Deduplication Rules:
1. **Extract & Index**: Extract all previously published titles, slugs, and tech stacks.
2. **Rejection Filter**: Immediately reject any topic that duplicates or closely mirrors past articles.
3. **Post-Cycle Logging**: Immediately after publishing each cycle, append the new records to BOTH `memory.md` files.

---

## 4. ✍️ Content Quality & Editorial Standards ("Content is King")

Every single article MUST adhere to these non-negotiable quality rules:

### A. High-CTR Title & SERP Engineering
- **Formula**: `[Power Word] + [Specific Metric/Result] + [Curiosity Gap] + [Year 2026]`
- **Examples**:
  - ✅ `"5 LangGraph Memory Patterns That Slashed Multi-Agent Latency by 64% in 2026"`
  - ✅ `"Building a Production OAuth2 FastMCP Server for Claude Code & Cursor [2026 Guide]"`
  - ✅ `"DeepSeek-V3 vs Claude 3.7 Sonnet: Real-World Token Economics & TTFT Benchmarks"`
  - ❌ `"Guide to AI Agents with LangGraph"` (REJECT: Generic, no metric, low CTR)

### B. Answer Engine Optimization (AEO) First Paragraph
- **Direct Answer First**: The first 80–120 words must answer the core search query immediately.
- **Zero Filler**: No introductory throat-clearing ("In today's fast-paced AI landscape...", "Artificial Intelligence is transforming..."). Start directly with the architecture, problem, and solution.

### C. Concise Depth & Runnable Multi-File Code (1,000 – 1,200 Words)
- **Strict Word Count**: Every article MUST be between **1,000 and 1,200 words** (calculated by stripping HTML/Markdown). Reject under 1,000 words or over 1,200 words.
- **No Repeated Paragraphs**: Every section must present unique, dense technical insights without reiteration or generic summaries.
- **Multi-File Runnable Code Blocks**: Provide complete, copy-pasteable files (e.g. `main.py`, `tools.py`, `config.yaml`, `.env.example`) with exact `pip install` or `uv run` commands.
- **Visuals**: Include ASCII or Mermaid architecture graphs illustrating state transitions, DAGs, or agent loops.
- **Benchmark / Comparison Table**: Include structured Markdown tables comparing metrics (latency ms, VRAM GB, token cost per 1M tokens, throughput).
- **"Production Reality Check"**: Include a dedicated section detailing rate-limit handling, memory leaks, retry exponential backoff, and failure recovery.

### D. Google E-E-A-T Signals
- **Experience**: Include real production deployment anecdotes ("In our production deployment at SaaSNext...", "When processing 10M+ tokens/day...").
- **Expertise**: Specific tool versions (e.g., `LangGraph v0.3.18`, `FastMCP v1.2.0`, `PydanticAI v0.0.24`).
- **Authoritativeness**: Linked author byline:  
  `By <a href="https://x.com/deeepakbagada" rel="nofollow noopener noreferrer">Deepak Bagada</a>, CEO at SaaSNext & Principal AI Architect.`
- **Trustworthiness**: Ending disclaimer:  
  `*Last tested: August 2026 with Python 3.12, Node v22, and latest framework releases.*`

### E. Semantic Heading Structure
- `h2`: Major architectural sections
- `h3`: Sub-modules, file breakdowns, step-by-step setup
- `h4`: Configuration options, utility helpers, edge case notes

---

## 5. 🔗 Dynamic Live HTTP 200 Internal Link Weaving

Every article MUST weave **3 to 5 contextual internal links** pointing ONLY to verified, live URLs returning HTTP 200.

### Step-by-Step Internal Link Protocol:
1. Run the verified links provider:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```
2. Select 3-5 relevant live articles or directory hub pages from the output:
   - AI Workflows Hub: `https://dailyaiworld.com/workflows`
   - MCP Directory Hub: `https://dailyaiworld.com/mcp-directory`
   - Latest AI News Hub: `https://dailyaiworld.com/latest-ai-news`
   - Relevant existing articles from the JSON output.
3. Weave links **contextually into the prose** (e.g. `"...similar to our benchmark on [Claude 3.7 vs DeepSeek-V3](https://dailyaiworld.com/blogs/...) which demonstrated..."`).
4. **All external links** MUST use `rel="nofollow noopener noreferrer"`. Internal links to `dailyaiworld.com` do NOT use nofollow.

---

## 6. 📄 Dispatch JSON Schema & Data Safety

Articles are saved as temporary JSON dispatch files conforming to this exact schema:

```json
{
  "title": "string (50-65 chars, high-CTR)",
  "seo_title": "string (ending with | Daily AI World)",
  "meta_description": "string (140-160 chars, starting with action verb)",
  "seo_keywords": "string (comma-separated, 5-8 keywords)",
  "category_id": 1,
  "deck": "string (concise executive briefing, 2-3 sentences)",
  "ai_summary": "string (executive summary for AI crawlers)",
  "excerpt": "string (card preview text)",
  "content": "string (full Markdown body, strictly 1,000-1,200 words, NO raw script tags)",
  "featured_image": "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80",
  "reading_time": 6,
  "key_takeaways": [
    "Takeaway 1: Specific architecture breakthrough",
    "Takeaway 2: Specific cost/performance benchmark",
    "Takeaway 3: Key production constraint"
  ],
  "faqs": [
    {
      "question": "What is the primary architectural advantage of this setup?",
      "answer": "Clear, detailed answer explaining the mechanism..."
    },
    {
      "question": "How does this compare in cost per 1M tokens?",
      "answer": "Concrete cost breakdown and comparison..."
    }
  ],
  "tier": "Deep Dive",
  "trending_score": 88.5
}
```

> [!CAUTION]  
> **NO RAW SCHEMA IN CONTENT**: Do NOT put `<script type="application/ld+json">` or markdown schema blocks inside the `content` string. Schema.org metadata, FAQs, and Takeaways are automatically rendered by the Blade view template from the structured JSON fields.

---

## 7. 🛠️ Execution Scripts Reference

All helper scripts reside in `/Users/deepakbagada/personal/Daily AI world/scripts/`:

1. **Publish Single Article to Dual-DB**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/publish_single_article.php /path/to/article_dispatch.json
   ```
   *Returns JSON with `success`, `slug`, `url`, `local_id`, and `remote_id`.*

2. **Audit Live URL (HTTP 200 & Quality Checks)**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_live_url.php "https://dailyaiworld.com/workflow/my-slug"
   ```
   *Validates HTTP 200, author byline, body content, and internal links.*

3. **Get Verified Internal Links**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```

---

## 8. 🔄 The 4-Cycle Execution Flow (Step-by-Step)

### CYCLE 1: AI Workflows (3 Articles)
1. **Search & Research**: Search trending 2026 agentic workflows (LangGraph, CrewAI, AutoGen, PydanticAI, LlamaIndex, n8n). Check `memory.md` to ensure zero duplicates.
2. **Fetch Live Links**: Run `php scripts/get_verified_internal_links.php` to obtain live 200 URLs.
3. **Write Articles**: Write 3 in-depth dispatches (**strictly 1,000 – 1,200 words each**) and save as:
   - `workflow_dispatch_1.json`
   - `workflow_dispatch_2.json`
   - `workflow_dispatch_3.json`
4. **Content Audit**: Verify:
   - **Word count: 1,000 to 1,200 words**
   - AEO answer-first opening paragraph
   - Title follows Power-CTR formula
   - Multi-file runnable code blocks + pip install
   - 3-5 verified live internal links
   - Linked Deepak Bagada author byline
   - No raw `<script>` tags in content
   - Zero repeated paragraphs
5. **Publish to Dual DB**: Run `php scripts/publish_single_article.php` for each JSON.
6. **Live URL Audit**: Run `php scripts/audit_live_url.php <url>` for each live URL to confirm HTTP 200.
7. **Log to Memory**: Append title, slug, and date to both `memory.md` files.

---

### CYCLE 2: MCP Directory (3 Articles)
1. **Search & Research**: Search novel Model Context Protocol (MCP) servers, FastMCP TypeScript/Python tools, SQLite/PostgreSQL/Kubernetes MCP servers, and Claude Code/Cursor integrations.
2. **Write Articles**: Write 3 in-depth dispatches (`category_id` = 5, **strictly 1,000 – 1,200 words**) and save as:
   - `mcp_dispatch_1.json`
   - `mcp_dispatch_2.json`
   - `mcp_dispatch_3.json`
   - *Include: Complete FastMCP server code, Zod schemas, `.cursor/mcp.json` and `claude_desktop_config.json` snippets.*
3. **Content Audit & Dual-DB Publish**: Audit (1,000-1,200 words) and run `php scripts/publish_single_article.php`.
4. **Live URL Audit & Memory Log**: Confirm HTTP 200 on `https://dailyaiworld.com/mcp-directory/{slug}` and append to `memory.md`.

---

### CYCLE 3: AI Technical Blogs (3 Articles)
1. **Search & Research**: Search frontier model benchmarks, token economics, agent governance, latency optimization, and architecture comparisons.
2. **Write Articles**: Write 3 in-depth dispatches (`category_id` = 3 or 10, **strictly 1,000 – 1,200 words**) and save as:
   - `blog_dispatch_1.json`
   - `blog_dispatch_2.json`
   - `blog_dispatch_3.json`
   - *Include: Comparative benchmark tables, unit economics, ROI calculations, and code snippets.*
3. **Content Audit & Dual-DB Publish**: Audit (1,000-1,200 words) and run `php scripts/publish_single_article.php`.
4. **Live URL Audit & Memory Log**: Confirm HTTP 200 on `https://dailyaiworld.com/blogs/{slug}` and append to `memory.md`.

---

### CYCLE 4: Technical AI News (3 Articles)
1. **Search & Research**: Search breaking 2026 AI industry news, frontier model releases, GPU cluster announcements, enterprise adoption milestones, or open-source weight drops.
2. **Write Articles**: Write 3 breaking technical dispatches (`category_id` = 11, **strictly 1,000 – 1,200 words**) and save as:
   - `news_dispatch_1.json`
   - `news_dispatch_2.json`
   - `news_dispatch_3.json`
   - *Include: Enterprise impact breakdown, token cost shifts, developer architectural takeaways.*
3. **Content Audit & Dual-DB Publish**: Audit (1,000-1,200 words) and run `php scripts/publish_single_article.php`.
4. **Live URL Audit & Memory Log**: Confirm HTTP 200 on `https://dailyaiworld.com/blogs/{slug}` and append to `memory.md`.

---

## 9. 📋 Final Run Verification Report

At the conclusion of the 4 cycles, output a clean structured summary:
- **Total Published**: 12/12 articles
- **Cycle Breakdown**:
  - AI Workflows (3/3) — All Live URLs + HTTP 200 status
  - MCP Directory (3/3) — All Live URLs + HTTP 200 status
  - AI Blogs (3/3) — All Live URLs + HTTP 200 status
  - AI News (3/3) — All Live URLs + HTTP 200 status
- **Average Word Count**: ~1,000 – 1,200 words per article
- **Dual-DB Sync Status**: Local MySQL + Hostinger Remote MySQL confirmed
- **Memory Log Status**: Updated in both memory files
