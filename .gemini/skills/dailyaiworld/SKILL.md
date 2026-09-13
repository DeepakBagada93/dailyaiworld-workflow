---
name: dailyaiworld
description: >
  Universal, production-grade autonomous content publishing skill for Daily AI World (dailyaiworld.com).
  Executes batch viral & trending SERP/AEO research first, followed by a strict sequential ONE-BY-ONE
  write → pre-publish audit → DIRECT push to Hostinger Live MySQL (`srv1334.hstgr.io`) → live URL format & HTTP 200 audit
  loop across high-CTR, high-E-E-A-T dispatches (AI Workflows + MCP Tools + AI Blogs + AI News).
  Engineered for Rank #1 Google SERP, Google AI Overview (AEO/GEO) citations, absolute zero duplicate content,
  zero numeric slug suffixes (-2/-3), verified live internal linking, genuine multi-author E-E-A-T credibility,
  and complete immunity against Google Search Console "Discovered - currently not indexed" flags.
  Word count constraint: 1,200 to 1,500 words per article (high density, zero fluff, runnable code).
  Zero git commits/pushes for content publishing to protect Google search indexing stability.
---

# 🌐 Daily AI World — Autonomous Content Engine v10.0 (Google Core Update, Zero-Duplicate & Search Console Compliance Edition)

> [!IMPORTANT]  
> **CORE ARCHITECTURE (SEARCH IN BATCH → WRITE ONE → AUDIT ONE → PUSH DIRECTLY TO LIVE DB → VERIFY LIVE URL → REPEAT)**:  
> 1. **Batch Search & Topic Queue First**: Search and score all viral & trending topics up front across all cycles with real search demand, user search intent, viral momentum, anti-duplication memory checks, and live database collision queries.
> 2. **Sequential One-By-One Execution**: **NEVER batch push or write all in parallel**. For each approved topic in sequence:
>    - **Step 1 — Fetch Verified Internal Links**: Run `php scripts/get_verified_internal_links.php` to obtain 3–5 guaranteed live HTTP 200 URLs from Hostinger DB.
>    - **Step 2 — Write 1 dispatch**: (1,200 – 1,500 words, high dwell-time engineering substance, runnable multi-file code, AEO/GEO answer-first block, 3–5 verified internal links, **NO FAQ headings in content**, specialist author signature).
>    - **Step 3 — Pre-Publish Audit**: Run `php scripts/audit_dispatch_payload.php <dispatch.json>` to enforce word count, verify internal links, ensure zero duplicate FAQs, verify live DB anti-duplication, block numeric slug suffixes, and pass the anti-hallucination factual integrity gate.
>    - **Step 4 — Direct Push to Live DB**: Run `php scripts/publish_single_article.php <dispatch.json>` which inserts directly into Hostinger Remote MySQL (`srv1334.hstgr.io`) as the primary database with automatic specialist author routing and realistic publication pacing.
>    - **Step 5 — Live URL Quality Audit**: Run `php scripts/audit_live_url.php <url>` to verify HTTP 200, author byline, body content, interactive FAQs, and zero duplicate FAQ blocks.
>    - **Step 6 — Log to `memory.md`**: Record slug, title, category, and date in both local and skill config `memory.md`.
>    - **Step 7 — Advance**: Proceed to the next topic ONLY after the current live URL is 100% verified.

---

## 🚫 ZERO DUPLICATION & GOOGLE SEARCH CONSOLE IMMUNITY POLICY

To permanently eliminate Google Search Console **"Discovered - currently not indexed"** and **"Duplicate without user-selected canonical"** errors:

1. **Strictly Zero Numeric Suffix Slugs**:
   - Slugs ending in `-[0-9]+` (e.g., `-2`, `-3`, `-4`) are **STRICTLY PROHIBITED**.
   - If a topic or slug already exists in any form, **DO NOT append a number**. Discard the topic immediately and research a completely distinct, orthogonal topic.
2. **Mandatory Live Database Collision Pre-Check**:
   - Before drafting, query Hostinger Live DB (`srv1334.hstgr.io`) to verify that neither the title nor the slug nor the core technical entities exist:
   ```bash
   php -r "
   require 'vendor/autoload.php';
   \$app = require_once 'bootstrap/app.php';
   \$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
   config(['database.connections.hostinger' => [
       'driver' => 'mysql', 'host' => 'srv1334.hstgr.io', 'port' => '3306',
       'database' => 'u775719140_dailyai', 'username' => 'u775719140_admin', 'password' => 'Dailyaiworld@3093'
   ]]);
   \$q = \$argv[1];
   \$exists = Illuminate\Support\Facades\DB::connection('hostinger')->table('articles')
       ->where('title', 'like', \"%\$q%\")->orWhere('slug', 'like', \"%\$q%\")->select('id', 'title', 'slug')->get();
   if (\$exists->isNotEmpty()) { echo \"EXISTS: \" . json_encode(\$exists) . PHP_EOL; exit(1); }
   echo \"CLEAN: Topic is 100% unique.\" . PHP_EOL;
   " "Target Keyword or Title"
   ```
3. **No Duplicate or Cannibalizing Content**:
   - Never write an article that duplicates an existing dispatch's problem statement, framework version, or architectural solution.
4. **Mandatory Live HTTP 200 Internal Links**:
   - Never invent or hallucinate internal URLs.
   - Always pull live links from `php scripts/get_verified_internal_links.php`.
   - Links must route to `/workflow/{slug}`, `/mcp-directory/{slug}`, `/blogs/{slug}`, or approved directory hubs (`/workflows`, `/mcp-directory`, `/latest-ai-news`).
5. **No Duplicate FAQs**:
   - The Blade view template automatically renders both the interactive FAQ accordion section and the JSON-LD `FAQPage` schema from the `"faqs"` array in the JSON payload.
   - **NEVER** write `## Frequently Asked Questions`, `### FAQ`, or any Q&A blocks inside the Markdown `content` body.
6. **Strict No Git Push For Content Policy**:
   - Articles live directly inside the MySQL database (`articles` table on `srv1334.hstgr.io`).
   - Pushing code to GitHub triggers unnecessary deployments on the live host, which disrupts active crawler sessions and harms Google indexing.

---

## 1. 👥 Multi-Author E-E-A-T Editorial Roster

To establish undeniable Experience, Expertise, Authoritativeness, and Trust (E-E-A-T) and avoid single-author algorithmic spam flags:

| Author Persona | Role / Title | Specialty & Category Alignment | Slug / Avatar |
|---|---|---|---|
| **Elena Rostova** | Principal Distributed Systems Architect | **Category 1 (AI Workflows)**, Multi-agent orchestration, LangGraph, CrewAI, AutoGen, stateful loops | `elena-rostova` |
| **Marcus Vance** | Head of Protocol Engineering | **Category 5 (MCP Tools & Directory)**, FastMCP, Model Context Protocol, Claude Desktop, Cursor tools | `marcus-vance` |
| **Dr. Aris Thorne** | Lead AI Research Fellow | **Category 3 & 10 (Coding, LLMs & Benchmarks)**, Token economics, inference latency, MoE scaling laws | `dr-aris-thorne` |
| **Daily AI World Editorial Bureau** | Staff Intelligence Desk | **Category 11 (AI News & Ecosystem)**, Breaking releases, AI policy, EU AI Act, funding & M&A | `daily-ai-world-editorial-bureau` |
| **Deepak Bagada** | Founder & Editor-in-Chief | **Enterprise Deep Dives & Executive Blueprints**, Sovereign AI, ROI architecture, SaaS scaling | `deepak-bagada` |

---

## 2. 📊 Dispatch Mix & Category Routing

| Cycle | Type | Category Name | Category ID | Canonical URL Route | Default Specialist Author | Strict Word Count | Dwell-Time Focus |
|---|---|---|---|---|---|---|---|
| **Cycle 1** | **AI Workflows** | AI Workflows | `1` | `https://dailyaiworld.com/workflow/{slug}` | Elena Rostova / Deepak Bagada | **1,200 – 1,500 words** | Multi-file runnable architecture, DAG graphs, stateful agent loops, failure recovery |
| **Cycle 2** | **MCP Directory** | AI Tools | `5` | `https://dailyaiworld.com/mcp-directory/{slug}` | Marcus Vance | **1,200 – 1,500 words** | FastMCP servers, custom tools, Zod schemas, Cursor/Claude/Windsurf integration |
| **Cycle 3** | **AI Blogs** | Coding / LLMs | `3` or `10` | `https://dailyaiworld.com/blogs/{slug}` | Dr. Aris Thorne | **1,200 – 1,500 words** | Benchmark tables, token economics, latency profiling, production trade-offs |
| **Cycle 4** | **AI News** | AI News | `11` | `https://dailyaiworld.com/blogs/{slug}` | Daily AI World Editorial Bureau | **1,200 – 1,500 words** | Breaking model releases, enterprise architecture impact, migration playbooks |

---

## 3. 🧠 STAGE 0: High-CTR, Viral & Unique Topic Discovery

### Step 0.1 — Dual Memory & DB Verification
1. Read both memory files:
   - Workspace: `/Users/deepakbagada/personal/Daily AI world/memory.md`
   - Config: `/Users/deepakbagada/.gemini/config/skills/dailyaiworld/memory.md`
2. Run the Hostinger DB duplicate query on target keywords.
3. If ANY match exists in title, slug, or technical focus, discard the topic immediately.

### Step 0.2 — Multi-Source Factual Verification Gate
- **MANDATORY**: Run `search_web` for any candidate framework, model release, or tool update.
- Verify exact real-world model names (e.g., `Claude 3.7 Sonnet`, `Gemini 2.5/3.0 Flash`, `DeepSeek-V3/R1`, `OpenAI o1/o3-mini`).
- **STRICTLY PROHIBITED**: Never fabricate unannounced models (e.g. "GPT-6", "GPT-7", fake vision versions) or fake enterprise acquisitions.
- Verify benchmark claims against real Hugging Face leaderboards, arXiv papers, or official GitHub repositories.

### Step 0.3 — High-Yield Scored Topic Ranking (0–100)
Score candidate topics:
```
Organic Search Demand (0-25) + Viral/Social Momentum (0-25) + Dwell-Time & Code Utility (0-25) + Commercial Value & High-CPM Intent (0-25) = /100
```
Only approve topics scoring **>= 85/100**.

---

## 4. 🎯 Rank #1 Google SERP, High-CTR & Revenue Meta Engineering

### A. High-CTR Title Engineering (50–65 Characters)
- **Formula 1 (Benchmark Showdown)**: `[Primary Tech]: [Concrete Metric] vs [Alternative] [2026]`
- **Formula 2 (Enterprise Blueprint)**: `How to Build an Enterprise [System] with [Stack]: [Metric] [2026]`
- **Formula 3 (Pain-Point Solution)**: `[Problem Solved] in [Tech Stack]: [Architectural Pattern] [2026 Guide]`

### B. High-Converting Meta Description (145–158 Characters)
- `[Imperative Action Verb] + [Primary Target Keyword] + [Exact Concrete Metric/Benefit] + [Secondary LSI Keyword] + [Click Incentive Hook].`
- Include the main keyword within the first 60 characters for mobile SERP snippet visibility.

### C. `seo_title` & `seo_keywords`
- `seo_title`: `[High CTR Title] | Daily AI World`
- `seo_keywords`: 6–8 comma-separated terms combining category keywords and long-tail technical queries.

---

## 5. 🤖 Google AI Overview & Generative Engine Optimization (AEO / GEO)

### A. The "AEO Direct Answer Box" (First 80–120 Words)
Directly under the H1 / introduction:
1. Provide a direct 2-sentence technical definition or answer that AI crawlers can quote directly.
2. Present a bulleted summary of the 3 primary architectural facts or metrics.
3. Zero fluff or filler introductions (avoid "In today's fast-paced world...").
4. **NO "## AEO Direct Answer Box" heading** — render directly in prose.

### B. High-Density Semantic Triples & Entity Anchoring
- Ground entity relationships: `[Subject] [Predicate] [Object]`.
- Explicitly cite software versions and hardware configurations (`Python 3.12`, `Node v22`, `PostgreSQL 16`, `NVIDIA H100`).

### C. Structured Markdown Tables & Step-by-Step Matrices
- **At least 1 Comparative Benchmark Table**: Real-world metrics (latency ms, cost per 1M tokens, throughput req/sec).
- **Numbered Implementation Steps**: Clear, ordered technical steps (`Step 1: Setup`, `Step 2: Core Server`, `Step 3: Verification`).

---

## 6. ✍️ Content Quality, Dwell-Time & E-E-A-T Architecture (1,200 – 1,500 Words)

1. **Strict Word Count Constraint**: Strictly **1,200 to 1,500 words** of dense, practical technical substance.
2. **Multi-File Runnable Code Blocks**: Complete, copy-paste-ready code files with explicit file headers (`server.py`, `config.yaml`). Include exact install commands (`uv pip install`, `pnpm add`).
3. **Mermaid & ASCII Architecture Diagrams**: Include at least 1 clear ASCII/Mermaid diagram visualizing request flows, state machines, or agent loops.
4. **"Production Reality Check" & Failure Modes Section**: Dedicated section detailing real-world bugs: rate limits, token budget explosions, tool hallucination, and fallback recovery patterns.
5. **E-E-A-T Author Signature & Timestamp**:
   - Author signature matching the designated author:
     `By <a href="https://x.com/deeepakbagada" rel="author">Elena Rostova</a>, Principal Distributed Systems Architect at Daily AI World.`
   - Verification date at bottom:
     `*Last tested & verified: September 2026 with Python 3.12, Node v22, and latest framework releases.*`

---

## 7. 🔗 Dynamic Live HTTP 200 Internal Link Weaving

Every article MUST weave **3 to 5 contextual internal links** to verified live URLs:
1. Run the link fetcher before writing:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```
2. Pick 3–5 relevant live URLs from the JSON output and weave them naturally into markdown body:
   `[Contextual Anchor Text](https://dailyaiworld.com/workflow/my-slug)`
3. Use standard markdown dofollow links for internal URLs; use `rel="nofollow noopener noreferrer"` on external links.
4. The pre-publish audit script will verify that every single internal link exists on Hostinger DB before publishing.

---

## 8. 📄 Dispatch JSON Schema

```json
{
  "title": "string (50-65 chars, high-CTR, year [2026], concrete metric)",
  "seo_title": "string (ending with | Daily AI World)",
  "meta_description": "string (145-158 chars, active verb, primary keyword, high CTR)",
  "seo_keywords": "string (comma-separated, 5-8 high-intent keywords)",
  "category_id": 1,
  "author_id": 3,
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

---

## 9. 🛠️ Execution & Quality Audit Scripts

All automated audit and publishing scripts reside in `/Users/deepakbagada/personal/Daily AI world/scripts/`:

1. **Verify Live Hostinger DB Connection**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/check_hostinger_connection.php
   ```

2. **Get Verified Internal Links**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/get_verified_internal_links.php
   ```

3. **Pre-Publish Payload Quality Gate Audit**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_dispatch_payload.php /path/to/dispatch.json
   ```
   *Validates: Word count (1,200–1,500), anti-duplicate FAQ check, 3–5 verified internal links against Hostinger DB, no numeric slug suffixes, live DB anti-duplication guard, factual integrity & anti-hallucination filter, accredited author attribution.*

4. **Direct Publish to Live Hostinger Database (`srv1334.hstgr.io`)**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/publish_single_article.php /path/to/dispatch.json
   ```
   *Directly inserts into Live Hostinger Database (`srv1334.hstgr.io`) as primary, rejects duplicate slugs/titles and numeric suffixes, automatically routes specialist author, paces publishing timestamp, and makes article immediately live without touching Git.*

5. **Live URL Quality & Layout Audit**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_live_url.php "https://dailyaiworld.com/workflow/my-slug"
   ```
   *Validates: HTTP 200 OK, author byline, body length, >=3 internal links, single FAQ accordion rendering, zero duplicate FAQ blocks.*

---

## 10. 🔄 Step-by-Step One-By-One Execution Protocol

```
For topic_index = 1 to N:
    1. VERIFY TOPIC: Check DB and memory.md for zero duplication. Perform web_search for factual integrity.
    2. FETCH LINKS: Run `php scripts/get_verified_internal_links.php` to obtain 3-5 guaranteed live internal links.
    3. WRITE: Write article payload matching 1,200–1,500 words + runnable code + AEO answer block + 3-5 verified links + NO FAQ in content markdown + designated author.
    4. PRE-PUBLISH AUDIT: Run `php scripts/audit_dispatch_payload.php <dispatch.json>`.
       - If audit fails: Fix word count / duplicate FAQ / internal link issues immediately before pushing.
    5. DIRECT LIVE PUSH: Run `php scripts/publish_single_article.php <dispatch.json>`.
       - Inserts directly to Live Hostinger DB (`srv1334.hstgr.io`).
       - DO NOT run git push or trigger deployments.
    6. LIVE URL AUDIT: Run `php scripts/audit_live_url.php <url>`.
       - If verification fails: Fix and re-publish before continuing.
    7. LOG: Append title, slug, category, author, and date to both `memory.md` files.
    8. PROCEED: Only now advance to the next topic.
```

---

## 11. 📋 Final Run Verification Report

Output a final verification table:
- **Total Published**: N articles
- **Cycle Breakdown Table**:
  - Index, Category, Title, Author Byline, Word Count, Verified Internal Links Count, Live URL, Live HTTP Status (200 OK)
- **Zero Duplicate FAQs**: Confirmed no dual FAQ sections on live pages
- **Zero Duplicate Titles/Slugs**: Confirmed live database unique constraint & zero numeric suffixes
- **Memory Log Status**: Confirmed updated in both workspace and config `memory.md`
