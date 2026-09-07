---
name: dailyaiworld
description: >
  Universal, production-grade autonomous content publishing skill for Daily AI World (dailyaiworld.com).
  Executes batch viral & trending SERP/AEO research first, followed by a strict sequential ONE-BY-ONE
  write → pre-publish audit → DIRECT push to Hostinger Live MySQL (`srv1334.hstgr.io`) → live URL format & HTTP 200 audit
  loop across 12 high-CTR, high-E-E-A-T dispatches (3 AI Workflows + 3 MCP Tools + 3 AI Blogs + 3 AI News).
  Engineered for Rank #1 Google SERP, Google AI Overview (AEO/GEO) citations, and maximum viral dwell time.
  Strict word count constraint: 1,200 to 1,500 words per article (high density, zero fluff, maximum dwell time) with fresh breaking analysis.
  Zero git commits/pushes for content publishing to protect Google search indexing stability.
---

# 🌐 Daily AI World — Autonomous Content Engine v8.0 (Direct Live DB & Instant AEO Edition)

> [!IMPORTANT]  
> **CORE ARCHITECTURE (SEARCH IN BATCH → WRITE ONE → AUDIT ONE → PUSH DIRECTLY TO LIVE DB → VERIFY LIVE URL → REPEAT)**:  
> 1. **Batch Search & Topic Queue First**: Search and score all viral & trending topics up front across all cycles with real search demand, user search intent, viral momentum, and anti-duplication memory checks.
> 2. **Sequential One-By-One Execution**: **NEVER batch push or write all in parallel**. For each approved topic in sequence:
>    - **Step 1 — Write 1 dispatch**: (1,200 – 1,500 words, high dwell-time engineering substance, runnable multi-file code, AEO/GEO answer-first block, 3–5 verified internal links, **NO FAQ headings in content**).
>    - **Step 2 — Pre-Publish Audit**: Run `php scripts/audit_dispatch_payload.php <dispatch.json>` to enforce word count, verify internal links, ensure zero duplicate FAQs, and check metadata.
>    - **Step 3 — Direct Push to Live DB**: Run `php scripts/publish_single_article.php <dispatch.json>` which inserts directly into Hostinger Remote MySQL (`srv1334.hstgr.io`) as the primary database, ensuring immediate live availability.
>    - **Step 4 — Live URL Quality Audit**: Run `php scripts/audit_live_url.php <url>` to verify HTTP 200, author byline, body content, interactive FAQs, and no duplicate FAQ blocks.
>    - **Step 5 — Log to `memory.md`**: Record slug, title, category, and date in both local and skill config `memory.md`.
>    - **Step 6 — Advance**: Proceed to the next topic ONLY after the current live URL is 100% verified.
> 
> **STRICT NO GIT PUSH FOR CONTENT POLICY**:
> - **NEVER run `git push` or deploy repository code when publishing content**.
> - Articles live directly inside the MySQL database (`articles` table on `srv1334.hstgr.io`). Pushing code to GitHub triggers unnecessary rebuilds and deployments on the live host which disrupts active crawler sessions and harms Google search indexing latency.
> 
> **ZERO DUPLICATE FAQS GUARANTEE**:
> The Laravel Blade template automatically renders both the interactive FAQ accordion section and the JSON-LD `FAQPage` schema from the `"faqs"` array in the JSON payload. **NEVER** write `## Frequently Asked Questions`, `### FAQ`, or any Q&A blocks inside the Markdown `content` body.

---

## 1. 🚀 Executive Architecture & Sequential Execution Loop

The pipeline produces **12 articles per run** organized into **4 content cycles** (3 AI Workflows + 3 MCP Tools + 3 AI Blogs + 3 AI News):

```
STEP 1: Batch Viral & Trending Research & Scored Topic Queue (12 Scored Topics)
        ├── Check memory.md (zero cannibalization)
        ├── SERP Top-10 + People-Also-Ask + Viral Social Signals (X, Reddit, HN, GitHub)
        ├── High-CTR & AI Overview (AEO/GEO) Traffic Scoring
        └── Form Approved Queue (3 Workflows + 3 MCP Tools + 3 Blogs + 3 News)
                                │
                                ▼
STEP 2: Sequential Execution Loop (ONE BY ONE — Strict 1-at-a-time pipeline)
        ┌──► [Topic 1 of 12]
        │     ├── 1. Fetch Verified Internal Links (`php scripts/get_verified_internal_links.php`)
        │     ├── 2. Write Dispatch (1,200–1,500 words + runnable code + AEO answer-box + 3-5 verified links, NO FAQ in markdown)
        │     ├── 3. Pre-Publish Audit (`php scripts/audit_dispatch_payload.php dispatch.json`)
        │     ├── 4. Direct Push to Live DB (`php scripts/publish_single_article.php dispatch.json` -> srv1334.hstgr.io)
        │     ├── 5. Live URL Audit (`php scripts/audit_live_url.php <live_url>`)
        │     └── 6. Log to memory.md
        ├──► [Topic 2 of 12] ──► Links ──► Write ──► Pre-Audit ──► Live Push ──► Live Audit ──► Log
        ├──► ...
        └──► [Topic 12 of 12] ──► Links ──► Write ──► Pre-Audit ──► Live Push ──► Live Audit ──► Log
                                │
                                ▼
STEP 3: Final Run Verification Report (12/12 Live URLs verified)
```

> [!CAUTION]  
> **NO BATCH PUSHING & NO GIT PUSH**: Never write or push multiple articles at once. Never push to GitHub for publishing content. All posts must be inserted directly into the live Hostinger database (`srv1334.hstgr.io`). If any single post fails pre-publish audit, DB push, or live URL audit, fix the issue immediately before proceeding to the next topic.

---

## 2. 📊 Dispatch Mix & Category Routing

| Cycle | Type | Category Name | Category ID | Canonical URL Route | Strict Word Count | Dwell-Time Focus |
|---|---|---|---|---|---|---|
| **Cycle 1** | **AI Workflows** | AI Workflows | `1` | `https://dailyaiworld.com/workflow/{slug}` | **1,200 – 1,500 words** | Multi-file runnable architecture, DAG graphs, stateful agent loops, failure recovery |
| **Cycle 2** | **MCP Directory** | AI Tools | `5` | `https://dailyaiworld.com/mcp-directory/{slug}` | **1,200 – 1,500 words** | FastMCP servers, custom tools, Zod schemas, Cursor/Claude/Windsurf integration |
| **Cycle 3** | **AI Blogs** | Coding / LLMs | `3` or `10` | `https://dailyaiworld.com/blogs/{slug}` | **1,200 – 1,500 words** | Benchmark tables, token economics, latency profiling, production trade-offs |
| **Cycle 4** | **AI News** | AI News | `11` | `https://dailyaiworld.com/blogs/{slug}` | **1,200 – 1,500 words** | Breaking model releases, enterprise architecture impact, migration playbooks |

---

## 3. 🧠 STAGE 0: High-CTR, Viral & Trending Topic Discovery (Traffic & Monetization Engine)

To capture millions of organic search impressions, viral social sharing, and high-CPM programmatic ad & affiliate revenue, the topic discovery engine operates across 5 high-yield intent vectors:

### Step 0.1 — Anti-Duplication Check (`memory.md`)
Read both memory files:
- Local Workspace: `/Users/deepakbagada/personal/Daily AI world/memory.md`
- Gemini Config: `/Users/deepakbagada/.gemini/config/skills/dailyaiworld/memory.md`

Extract all past titles, slugs, and tech stacks. Discard any candidate that cannibalizes past keywords.

### Step 0.2 — High-Velocity Viral & High-CPM Discovery Vectors

| Intent Vector | Search Query Archetypes | Target Audience & Monetization Hook |
|---|---|---|
| **Viral Social Heat & Breakthroughs** | `web_search "<model/framework> (site:x.com OR site:reddit.com/r/LocalLLaMA OR site:news.ycombinator.com OR site:github.com/trending)"` | Developers, founders, researchers. High viral share potential on Twitter/X, Reddit, Hacker News. |
| **High CPC Enterprise Intent ($15–$50 CPM)** | `web_search "how to build enterprise <agent/RAG/fintech> production architecture 2026"` | CTOs, VP Engineering, AI Architects looking for high-value enterprise deployment patterns (premium ad CPMs & sponsored tool placements). |
| **Zero-to-One Technical Pain Points & PAA** | `web_search "<tech> production error OR benchmark comparison OR latency bottleneck guide 2026"` | Direct Google SERP snatching via People-Also-Ask & featured snippets. Captures users actively debugging implementations. |
| **Breaking Releases & Ecosystem Dominance** | `web_search "new AI model release OR MCP protocol update OR Anthropic Google OpenAI announcement 2026"` | Immediate news-cycle traffic surges (Google Discover, Google News, Flipboard). |
| **ROI, Cost-Cutting & Token Economics** | `web_search "<model A> vs <model B> cost per 1M tokens enterprise benchmark 2026"` | High-intent buyers optimizing massive inference bills. Extreme dwell time on tables & charts. |

### Step 0.3 — High-Yield Scored Topic Ranking (0–100)
Score candidate topics before inclusion:
```
Organic Search Volume & PAA Demand (0-25) + Viral/Social Momentum (0-25) + Dwell-Time & Code Utility (0-25) + Commercial Value & High-CPM Intent (0-25) = /100
```
Only approve topics scoring **>= 85/100**.

---

## 4. 🎯 Rank #1 Google SERP, High-CTR & Revenue Meta Engineering

Every article must be engineered to stand out in Google Search results and social timelines to maximize Click-Through Rate (CTR):

### A. High-CTR Title Engineering (50–65 Characters)
Titles must combine a strong primary keyword, a curiosity or breakthrough hook, concrete metrics, and year tags:
- **Formula 1 (Breakthrough Benchmark)**: `[Primary Tech]: [Concrete Metric/Result] vs [Alternative] [2026]`
  - *Example*: `"Claude 3.7 Sonnet Hybrid Reasoning: 64% Lower Latency in Production [2026]"`
- **Formula 2 (Enterprise Blueprint)**: `How to Build an Enterprise [System] with [Stack]: [Concrete Metric] [2026]`
  - *Example*: `"Build an Enterprise FastMCP PostgreSQL Gateway: Cut DB Latency by 52% in 2026"`
- **Formula 3 (Pain-Point Solution)**: `[Problem Solved] in [Tech Stack]: [Architectural Breakthrough] [2026 Guide]`
  - *Example*: `"Stop Agent Memory Leaks: 4 Graphiti & Redis Patterns for 99.4% Accuracy [2026]"`

### B. High-Converting Meta Description (145–158 Characters)
- **Structure**: `[Imperative Action Verb] + [Primary Target Keyword] + [Exact Concrete Metric/Benefit] + [Secondary LSI Keyword] + [Click Incentive / Curiosity Hook].`
- Include the main keyword within the first 60 characters for maximum mobile SERP snippet visibility.

### C. `seo_title` & `seo_keywords`
- `seo_title`: Format as `[High CTR Title] | Daily AI World`
- `seo_keywords`: 6–8 comma-separated terms combining broad category keywords, long-tail search phrases, and commercial intent modifiers (e.g. `fastmcp tutorial, claude desktop postgres, enterprise mcp server 2026, model context protocol architecture`).

---

## 5. 🤖 Google AI Overview & Generative Engine Optimization (AEO / GEO)

AI search engines (Google AI Overviews, SearchGPT, Perplexity, Claude Cite) summarize high-authority, direct-answer sources. Every post MUST include:

### A. The "AEO Direct Answer Block" (First 80–120 Words, No Visible Heading)
Directly under the H1/introductory hook in the `content` body:
1. Provide a direct 2-sentence technical definition or answer that AI crawlers can quote directly.
2. Present a bulleted summary of the 3 primary architectural facts or metrics.
3. Zero fluff or filler introductions (avoid "In this fast-paced world...").

> [!CAUTION]
> **NEVER use `## AEO Direct Answer Box` or any heading marker for the AEO block.**
> The AEO content must be the first paragraph(s) of the `content` field WITHOUT any preceding heading.
> A visible `## AEO Direct Answer Box` heading renders as an `<h2>` in the article body AND pollutes the Table of Contents.
> The `ai_summary` JSON field and Schema.org `TechArticle` JSON-LD (rendered automatically by the blade template)
> already handle all AEO/GEO metadata for AI search engines. Using a markdown heading duplicates this structure visually.
> 
> **Correct pattern**: The content starts with the AEO description text directly, no heading:
> ```
> content: "Google's MCP Toolbox for Databases is an open-source... [2-sentence definition].\n\n- Feature 1...\n- Feature 2...\n\n---\n\n## Real Content Heading Starts Here"
> ```
> 
> **Incorrect pattern** (will be BLOCKED by audit):
> ```
> content: "## AEO Direct Answer Box\n\nGoogle's MCP Toolbox..."
> ```

### B. High-Density Semantic Triples & Entity Anchoring
- Ground entity relationships explicitly: `[Subject] [Predicate] [Object]` (e.g., `FastMCP (Subject) standardizes (Predicate) client-tool RPC transports over SSE and stdio (Object)`).
- Explicitly cite software versions, benchmark environments, hardware configurations (`Python 3.12`, `Node v22`, `PostgreSQL 16`, `NVIDIA H100`).

### C. Structured Markdown Tables & Step-by-Step Matrices
- **At least 1 Comparative Benchmark Table**: Real-world metrics (latency ms, cost per 1M tokens, throughput req/sec, memory overhead).
- **Numbered Implementation Playbooks**: Clear, ordered technical steps (`Step 1: Setup`, `Step 2: Core Server`, `Step 3: Verification`).

---

## 6. ✍️ Content Quality, Dwell-Time & E-E-A-T Architecture (1,200 – 1,500 Words)

To keep reader dwell time high (>4.5 minutes), reduce bounce rate, and establish unmatched E-E-A-T authority:

1. **Strict Word Count Constraint**: Strictly **1,200 to 1,500 words** per article of dense, practical technical substance.
2. **Multi-File Runnable Code Blocks**:
   - Provide complete, copy-paste-ready code files with explicit file headers (`server.py`, `config.yaml`, `tools.ts`).
   - Include exact install and run commands (`uv pip install`, `pnpm add`, `docker compose up`).
3. **Mermaid & ASCII Architecture Diagrams**:
   - Include at least 1 clear ASCII/Mermaid diagram visualizing request flows, state machines, or agent communication loops.
4. **"Production Reality Check" & Failure Modes Section**:
   - Every post must include a dedicated failure modes section detailing real-world bugs: rate limits, token budget explosions, silent tool hallucination, and fallback recovery patterns.
5. **E-E-A-T Author Signature & Timestamp**:
   - Author signature at top:
     `By <a href="https://x.com/deeepakbagada" rel="nofollow noopener noreferrer">Deepak Bagada</a>, CEO at SaaSNext & Principal AI Architect.`
   - Verification date at bottom:
     `*Last tested & verified: September 2026 with Python 3.12, Node v22, and latest framework releases.*`
6. **Engagement & Monetization CTA Hooks**:
   - Weave natural CTAs connecting readers to the [AI Workflows Directory](https://dailyaiworld.com/workflows) and [MCP Directory](https://dailyaiworld.com/mcp-directory) to increase session depth and internal pageviews.

---

## 7. 🚫 Strict Anti-Duplicate FAQ Architecture

> [!CAUTION]  
> **NEVER PUT FAQ / Q&A HEADINGS IN MARKDOWN CONTENT**:  
> - The Blade view template (`views/articles/show.blade.php`) automatically generates the interactive FAQ accordion UI and JSON-LD schema using the `"faqs"` JSON array.  
> - If you place `## Frequently Asked Questions`, `### FAQ`, or `**Q:**` inside `content`, the FAQ will appear **TWICE** on the live webpage!  
> - **RULE**: All FAQs must live **exclusively** in the `"faqs"` key of the article JSON.

---

## 8. 🔗 Dynamic Live HTTP 200 Internal Link Weaving

Every article MUST weave **3 to 5 contextual internal links** to verified live URLs:
1. Run the link fetcher before writing:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```
2. Pick 3–5 relevant live URLs from the JSON output and weave them naturally into the article markdown body using markdown syntax:
   `[Contextual Anchor Text](https://dailyaiworld.com/workflow/my-slug)`
3. Use `rel="nofollow noopener noreferrer"` on external links; keep internal links standard markdown dofollow.

---

## 9. 📄 Dispatch JSON Schema

Save each single post as a standalone JSON file (e.g. `scratch/dispatch_current.json`):

```json
{
  "title": "string (50-65 chars, high-CTR, year [2026], concrete metric)",
  "seo_title": "string (ending with | Daily AI World)",
  "meta_description": "string (145-158 chars, active verb, primary keyword, high CTR)",
  "seo_keywords": "string (comma-separated, 5-8 high-intent keywords)",
  "category_id": 1,
  "deck": "string (concise executive briefing, 2-3 sentences)",
  "ai_summary": "string (structured AEO summary for search & AI crawlers)",
  "excerpt": "string (card preview text)",
  "content": "string (full Markdown body, strictly 1,200-1,500 words, AEO direct answer block, 3-5 verified internal links, runnable multi-file code, benchmark tables, NO raw script tags, NO duplicate FAQ headings)",
  "featured_image": "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80",
  "reading_time": 7,
  "key_takeaways": [
    "Takeaway 1: Specific architectural breakthrough & latency metric",
    "Takeaway 2: Concrete cost/token economy comparison",
    "Takeaway 3: Key production mitigation pattern"
  ],
  "faqs": [
    {
      "question": "What is the primary architectural advantage of this setup?",
      "answer": "Clear, detailed answer explaining the mechanism..."
    },
    {
      "question": "How does this compare in cost per 1M tokens?",
      "answer": "Concrete cost breakdown and comparison..."
    },
    {
      "question": "What are the common failure modes in high-concurrency production?",
      "answer": "Specific breakdown of mitigation patterns and fallbacks..."
    }
  ],
  "tier": "Deep Dive",
  "trending_score": 92.5
}
```

> [!CAUTION]  
> **NO RAW SCHEMA IN CONTENT**: Do NOT place `<script type="application/ld+json">` inside the `content` string. The blade template renders FAQ and Article schema automatically.

---

## 10. 🛠️ Execution & Quality Audit Scripts

All automated audit and publishing scripts reside in `/Users/deepakbagada/personal/Daily AI world/scripts/`:

1. **Verify Live Hostinger DB Connection**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/check_hostinger_connection.php
   ```
   *Validates: Remote MySQL connection to `srv1334.hstgr.io:3306` with database `u775719140_dailyai`.*

2. **Get Verified Internal Links**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```

3. **Pre-Publish Payload Quality Gate Audit**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_dispatch_payload.php /path/to/dispatch.json
   ```
   *Validates: Word count (1,200–1,500), anti-duplicate FAQ check, 3–5 verified internal links, no raw `<script>` tags, E-E-A-T author signature, valid FAQs and key takeaways.*

4. **Direct Publish to Live Hostinger Database (`srv1334.hstgr.io`)**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/publish_single_article.php /path/to/dispatch.json
   ```
   *Directly inserts into Live Hostinger Database (`srv1334.hstgr.io`) as primary, triggers IndexNow/sitemaps, and makes the article immediately live without touching Git.*

5. **Live URL Quality & Layout Audit**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_live_url.php "https://dailyaiworld.com/workflow/my-slug"
   ```
   *Validates: HTTP 200 OK, author byline, body length, >=3 internal links, single FAQ accordion rendering, and zero duplicate FAQ blocks.*

---

## 11. 🔄 Step-by-Step One-By-One Execution Protocol

Follow this exact loop for each of the 12 topics:

```
For topic_index = 1 to 12:
    1. FETCH LINKS: Run `php scripts/get_verified_internal_links.php` to obtain 3-5 real internal links.
    2. WRITE: Write article payload matching 1,200–1,500 words + runnable code + AEO answer block + 3-5 verified links + NO FAQ in content markdown.
    3. PRE-PUBLISH AUDIT: Run `php scripts/audit_dispatch_payload.php <dispatch.json>`.
       - If pre-publish audit fails: Fix word count / duplicate FAQ / internal link issues immediately before pushing.
    4. DIRECT LIVE PUSH: Run `php scripts/publish_single_article.php <dispatch.json>`.
       - Inserts directly to Live Hostinger DB (`srv1334.hstgr.io`).
       - DO NOT run git push or trigger deployments.
    5. LIVE URL AUDIT: Run `php scripts/audit_live_url.php <url>`.
       - If verification fails: Fix and re-publish before continuing.
    6. LOG: Append title, slug, category, and date to both `memory.md` files.
    7. PROCEED: Only now advance to topic_index + 1.
```

### Cycle Breakdown:
- **Topics 1–3 (Cycle 1 - AI Workflows)**: `category_id` = 1, URL route `https://dailyaiworld.com/workflow/{slug}`
- **Topics 4–6 (Cycle 2 - MCP Tools)**: `category_id` = 5, URL route `https://dailyaiworld.com/mcp-directory/{slug}`
- **Topics 7–9 (Cycle 3 - AI Blogs)**: `category_id` = 3 or 10, URL route `https://dailyaiworld.com/blogs/{slug}`
- **Topics 10–12 (Cycle 4 - AI News)**: `category_id` = 11, URL route `https://dailyaiworld.com/blogs/{slug}`

---

## 12. 📋 Final Run Verification Report

At the conclusion of all 12 articles, output a final verification table:
- **Total Published**: 12/12 articles
- **Cycle Breakdown Table**:
  - Index (1–12), Category, Title, Slug, Word Count, Verified Internal Links Count, Live URL, Live HTTP Status (200 OK)
- **Dual-DB Sync Status**: Local MySQL + Hostinger Remote MySQL confirmed for each post
- **Zero Duplicate FAQs**: Confirmed no dual FAQ sections on live pages
- **Memory Log Status**: Confirmed updated in both workspace and config `memory.md`
