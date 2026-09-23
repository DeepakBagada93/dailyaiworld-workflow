---
name: dailyaiworld
description: >
  Universal, production-grade autonomous content publishing skill for Daily AI World (dailyaiworld.com).
  Engineered to eliminate synthetic AI writing patterns, defeat Google Helpful Content System / Core Update
  penalties, and enforce genuine 100% human-written engineering depth from Founder & Editor-in-Chief Deepak Bagada.
  Executes a strict 4-CYCLE SEQUENTIAL ONE-BY-ONE loop (Search One → Write One → Audit One → Direct Push to Live DB → Verify Live URL → Push Google Indexing API → Log Memory → Repeat).
  Features an automated date-driven scaling engine: Days 1-30 (Sep 22 - Oct 22, 2026) at 6 Dispatches/day for crawl protection, Days 31-60 (Oct 23 - Nov 21, 2026) at 10 Dispatches/day, Days 61-90 (Nov 22 - Dec 21, 2026) at 16 Dispatches/day, and Days 91+ at 20 Dispatches/day.
  Titles engineered for maximum CTR featuring clean, natural, authoritative editorial headlines with high-converting
  symbols (:, —, |, //, $, %, →, &) — STRICTLY ZERO SQUARE BRACKETS ([ ]).
  Mandatory 145–158 character meta description, keyword-first SEO title, synchronized deck, and dense AEO/GEO optimization.
  Strict word count: 1,200 to 1,500 words per article (dense, practical, multi-file runnable code, zero fluff).
  Zero git commits/pushes for content publishing to protect Google search indexing stability.
---

# 🌐 Daily AI World — Autonomous Content Engine v16.0
### (4-Cycle Sequential Architecture: Search One-by-One → Write One-by-One → Push One-by-One | Automated Progressive Scaling Engine)

> [!IMPORTANT]  
> **CORE ARCHITECTURE: 4 CYCLES — STRICT ITEM-BY-ITEM CLOSED LOOP**:  
> Every execution of this skill runs through **4 sequential cycles**.
>
> ### 📅 AUTOMATIC DATE-DRIVEN PROGRESSIVE SCALING ENGINE:
> The engine automatically determines today's dispatch quota based on elapsed calendar days from the anchor baseline date (**2026-09-22**):
>
> * **Phase 1 (Days 1–30 | 2026-09-22 to 2026-10-22) — Crawl Budget Protection (6 Dispatches Total)**:
>   - Cycle 1: **1 Workflow** (`/workflow/{slug}`)
>   - Cycle 2: **1 MCP Directory** (`/mcp-directory/{slug}`)
>   - Cycle 3: **2 AI Blogs** (`/blogs/{slug}`)
>   - Cycle 4: **2 Latest AI News** (`/blogs/{slug}`)
>   - *Purpose*: Protect crawl budget while Google digests and indexes the 157 discovered backlog URLs.
>
> * **Phase 2 (Days 31–60 | 2026-10-23 to 2026-11-21) — Gradual Expansion (10 Dispatches Total)**:
>   - Cycle 1: **2 Workflows**
>   - Cycle 2: **2 MCP Directory**
>   - Cycle 3: **3 AI Blogs**
>   - Cycle 4: **3 Latest AI News**
>   - *Purpose*: Ramp up indexing throughput as Googlebot increases crawl frequency.
>
> * **Phase 3 (Days 61–90 | 2026-11-22 to 2026-12-21) — Full Scale Mode (16 Dispatches Total)**:
>   - Cycle 1: **2 Workflows**
>   - Cycle 2: **2 MCP Directory**
>   - Cycle 3: **6 AI Blogs**
>   - Cycle 4: **6 Latest AI News**
>   - *Purpose*: High-velocity topical dominance across agentic AI engineering queries.
>
> * **Phase 4 (Days 91+ | 2026-12-22 Onwards) — Enterprise Authority Scale (20 Dispatches Total)**:
>   - Cycle 1: **3 Workflows**
>   - Cycle 2: **3 MCP Directory**
>   - Cycle 3: **7 AI Blogs**
>   - Cycle 4: **7 Latest AI News**
>   - *Purpose*: Full-scale authority publishing across all categories.
>
> **MANDATORY SEQUENTIAL FLOW (SEARCH 1 → WRITE 1 → PUSH 1)**:  
> **NEVER batch search or write articles in parallel**. For each individual article in sequence:
> - **Step 1 — Search Trending Topic**: Run real-time `search_web` for a fresh, viral topic matching the current cycle with high search demand and commercial intent.
> - **Step 2 — Anti-Duplication & Live DB Collision Pre-Check**: Check `memory.md` and query Hostinger Live DB (`srv1334.hstgr.io`, DB `u775719140_dailyai`) to verify zero collision on title, slug, or technical concepts. Reject any numeric slug suffixes (`-[0-9]+` strictly banned). Check topic keywords to prevent search intent cannibalization.
> - **Step 3 — Fetch Verified Internal Links**: Run `php scripts/get_verified_internal_links.php` to obtain 3–5 guaranteed live HTTP 200 URLs directly from Hostinger Live DB. Intentionally include links to previously discovered articles and the 3 core hubs (`/workflows`, `/mcp-directory`, `/latest-ai-news`) to pull Googlebot deeper into the site and prevent orphan pages.
> - **Step 4 — Write 1 Dispatch Payload**: (Strictly 1,200 – 1,500 words — zero thin content, clean high-CTR title with **ZERO SQUARE BRACKETS**, mandatory `seo_title`, strictly 145–158 char `meta_description` synchronized with `deck`, first-person engineering voice of Deepak Bagada, production war stories, runnable multi-file code, AEO direct answer block, 3–5 verified internal links, **NO FAQ headings in content body**, interactive FAQs array, author signature).
> - **Step 5 — Pre-Publish Audit**: Run `php scripts/audit_dispatch_payload.php <dispatch.json>` to enforce zero square brackets in title, word count (1,200–1,500), meta description length (140–160 chars), deck synchronization, verified internal links, banned AI buzzwords, zero duplicate FAQs, live DB uniqueness, and block numeric slug suffixes.
> - **Step 6 — Direct Push to Hostinger Live DB (Primary Target)**: Run `php scripts/publish_single_article.php <dispatch.json>` which inserts directly into **Hostinger Remote MySQL (`srv1334.hstgr.io`) as the exclusive live production database** with Deepak Bagada (`author_id = 1`) as sole author and realistic publication pacing. Local DB is secondary/optional. **Zero git commits/pushes for content publishing**.
> - **Step 7 — Live URL Quality Audit & Fast Indexing API**: Run `php scripts/audit_live_url.php <url>` to verify HTTP 200 OK, author byline (Deepak Bagada), body content, meta tags, and interactive FAQs. Optionally queue for Google Indexing API via `App\Services\GoogleIndexingService::publishUrl($url)` when quota is active.
> - **Step 8 — Log to `memory.md`**: Record slug, title, category, author, and date in `memory.md` and `.agent/skills/dailyaiworld/memory.md`.
> - **Step 9 — Advance to Next Article**: Only when the current article is verified 100% live on Hostinger and healthy, proceed to search and write the next article in the cycle.

---

## 🎯 HIGH-CTR EDITORIAL TITLE ARCHITECTURE (STRICTLY ZERO SQUARE BRACKETS)

> [!CAUTION]
> **STRICT BAN: ZERO SQUARE BRACKETS IN TITLES (`[ ]`)**  
> **NEVER use square brackets in article titles or SEO titles.**
> Bracket tags like `[Analysis]`, `[Guide]`, `[Blueprint]`, `[Deep Dive]`, `[Playbook]`, `[Benchmark]`, `[2026]`, `[Step-by-Step]` are **STRICTLY FORBIDDEN**.
>
> **Why this policy exists**:
> Square brackets look repetitive, synthetic, and spammy in Google search results. Overusing bracket tags like `[Analysis]` triggers algorithmic quality flags under Google's helpful content systems and degrades user trust.
>
> ❌ **BANNED (Bracket Tag Title)**:
> `Cloudera x Mistral: Private Frontier Inference Meets Your Governed Data [Analysis]`
>
> ✅ **APPROVED (Clean Authoritative Editorial Title)**:
> `Cloudera x Mistral: Private Frontier Inference Meets Governed Enterprise Data`

### 1. High-Converting Symbol Palette (Bracket-Free)
Engineers click on specific, high-signal technical headlines. Use these clean, non-bracket characters to structure titles:
* **Punctuation & Power Separators**: Colon `:`, Em-dash `—`, Vertical pipe `|`, Forward slashes `//`
* **Metrics, Currency & Operators**: `$0.002/Token`, `99.4% Latency Drop`, `+140% Speed`, `42ms`, `→`, `&`, `%`
* **Parentheses (Natural Technical Clarifications Only)**: `(FastMCP 4.0)`, `(Full Implementation)`, `(SWE-bench)` — use sparingly and only when clarifying an exact version or tool, never as a repetitive classification tag.

### 2. High-CTR Title Formulas by Category (All Bracket-Free)
* **AI Workflows**:
  - `Multi-Agent DAG Orchestration with LangGraph: 68% Cost Drop and Zero Token Waste`
  - `Build an Autonomous Code Review Workflow with Claude 3.7 and Temporal`
  - `Stateful Agent Swarms in Production: Self-Healing Loops and Zero Token Waste`
  - `Deterministic Workflow Recovery in LangGraph: Handling 429 Rate Spikes at Scale`
* **MCP Directory**:
  - `Build a FastMCP SQLite Server with 42ms Response Times and Zero Overhead`
  - `Hardened MCP Gateway Playbook: Securing 200+ Agent Tools with Zod Schemas`
  - `Build an Enterprise PostgreSQL MCP Server for Claude and Cursor`
  - `Migrate to Stateless MCP 2026: Cutting Session Overhead by 90% on Cloudflare Workers`
* **AI Blogs**:
  - `Claude 3.7 Sonnet vs GPT-4.5: Terminal Benchmark Showdown and Token Economics`
  - `Agent Memory Architecture in 2026: Episodic vs Vector vs Graph RAG Showdown`
  - `DeepSeek V4 Flash Codex Pro: 82.7% HumanEval Win and Zero Hallucinations`
  - `Price per Task vs Price per Token: Databricks Benchmark Verdict for Coding Agents`
* **Latest AI News**:
  - `Cloudera x Mistral: Private Frontier Inference Meets Governed Enterprise Data`
  - `OpenAI Ships GPT-6 Astra: 128k Reasoning Horizon and Multi-Agent Swarms`
  - `Anthropic Unveils Tool Search GA: 85% Context Savings for Production Agents`
  - `Google Releases Gemini 3.7 Flash: 340 tok/s at $0.75/1M as the New Coding Standard`

### 3. Clean Slug Safety Rule
* Slugs must be clean, hyphenated lowercase alphanumeric (e.g. `cloudera-mistral-private-frontier-inference-governed-data`).
* **Strictly prohibit numeric suffixes** (`-[0-9]+` like `-2`, `-3`) in slugs.
* Slugs must strip stop words and keep under 60 characters for crisp SERP URLs.

---

## 🔍 MANDATORY SEO & AEO METADATA ARCHITECTURE

Every single dispatch MUST have fully engineered, audited metadata for search engines (SEO) and AI answer engines (AEO / GEO):

```
┌─────────────────────────────────────────────────────────────────────────────────────────────┐
│                                 SEO & AEO METADATA MATRIX                                   │
├───────────────────┬───────────────────────────────┬─────────────────────────────────────────┤
│ Field             │ Strict Constraint             │ Requirement & Intent Purpose            │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ title             │ 50–65 characters              │ Clean, natural editorial headline.      │
│                   │ ZERO SQUARE BRACKETS ([ ])    │ Contains primary target keyword.        │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ seo_title         │ 50–60 characters (max 65)     │ Front-loads keyword for Google SERPs.   │
│ (meta_title)      │ Ends with: | Daily AI World   │ STRICTLY ZERO SQUARE BRACKETS ([ ]).    │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ meta_description  │ STRICTLY 145–158 characters   │ Active verb hook + primary keyword in   │
│                   │ Never <140, never >160        │ first 60 chars + concrete AEO answer +  │
│                   │ ZERO SQUARE BRACKETS ([ ])    │ proof metric + CTR call-to-read.        │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ deck              │ STRICTLY 145–158 characters   │ MUST MATCH meta_description VERBATIM.   │
│                   │ (Synchronized with meta_desc) │ Blade view uses deck for HTML meta tag. │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ ai_summary        │ 2–3 dense sentences           │ Factual synthesis for AI search engines │
│                   │ (180–240 characters)          │ (Perplexity, Google AI Overviews).      │
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ excerpt           │ 80–110 characters             │ Punchy teaser for card previews & feeds.│
├───────────────────┼───────────────────────────────┼─────────────────────────────────────────┤
│ seo_keywords      │ 5–8 comma-separated terms     │ High-intent transactional & tech terms. │
└───────────────────┴───────────────────────────────┴─────────────────────────────────────────┘
```

### 1. `seo_title` Engineering Rules
- **Length**: Strictly 50 to 60 characters (absolute maximum 65).
- **Structure**: `[Primary Keyword]: [Compelling Value Proposition] | Daily AI World`
- **Keyword Placement**: Primary target query within the first 30 characters.
- **Zero Brackets**: No `[Analysis]`, `[2026]`, `[Guide]`.

### 2. `meta_description` Engineering Rules (The 145–158 Char Formula)
Google truncates snippets over 160 characters with `...` and ignores descriptions shorter than 130 characters.
Every `meta_description` must follow this 4-part formula:
1. **Active Verb Hook (Words 1–3)**: `Explore how...`, `Discover how...`, `Benchmark...`, `Build a...`, `Compare...`, `Deploy...`.
2. **Primary Keyword (Within first 60 chars)**: Must include the exact primary search entity.
3. **AEO Direct Answer / Core Metric**: Provide the tangible takeaway (e.g. `cutting latency 42ms`, `saving 68% tokens`, `testing 50 tasks`).
4. **Click-Through Hook**: Prompt the reader to inspect the full architecture or implementation.

*Example*:
`Explore how Cloudera and Mistral bring private frontier inference to governed enterprise data with 6.3x leak protection math and complete migration steps.` (154 characters — PERFECT)

### 3. Critical `deck` Synchronization Rule
In Daily AI World's production Laravel application:
`resources/views/articles/show.blade.php` executes:
```blade
@section('meta_description', Str::limit($article->deck ?? $article->excerpt, 155))
```
Because the Blade template renders `<meta name="description">` from `$article->deck`, **the `deck` field in the JSON payload MUST be identical to `meta_description`**.
If `deck` is longer than 155 characters, Laravel cuts it mid-sentence. Keeping both `meta_description` and `deck` strictly between **145 and 158 characters** guarantees 100% clean display on Google, Twitter Cards, and OpenGraph.

---

## 📊 THE 4-CYCLE PRODUCTION MIX (AUTOMATED PROGRESSIVE SCALING ENGINE)

To safeguard Googlebot crawl efficiency, eliminate **"Discovered - currently not indexed"** queue throttling, and maximize long-term indexation momentum, the engine **dynamically calculates today's dispatch count** by checking the current calendar date against the baseline anchor date (**2026-09-22**):

```
Elapsed Days = (Current Date - 2026-09-22)
```

### 🗓️ Automated Phase Schedule & Quota Table:

| Phase | Calendar Date Range | Elapsed Days | Total Dispatches | Cycle 1 (Workflows) | Cycle 2 (MCP Directory) | Cycle 3 (AI Blogs) | Cycle 4 (AI News) | Primary Strategic Goal |
|---|---|---|---|---|---|---|---|---|
| **Phase 1: Safe Crawl Budget** | **2026-09-22 to 2026-10-22** | Days 1 – 30 | **6 Dispatches** | 1 | 1 | 2 | 2 | **Crawl Budget Protection**: Allows Googlebot to fully index the 157 discovered URLs backlog without spam/overload flags. |
| **Phase 2: Gradual Scale** | **2026-10-23 to 2026-11-21** | Days 31 – 60 | **10 Dispatches** | 2 | 2 | 3 | 3 | **Indexing Expansion**: Steps up publishing volume as Googlebot re-crawls daily and domain crawl budget widens. |
| **Phase 3: High Scale Mode** | **2026-11-22 to 2026-12-21** | Days 61 – 90 | **16 Dispatches** | 2 | 2 | 6 | 6 | **Market Dominance**: High-velocity topical coverage across AI models, coding agents, and frontier frameworks. |
| **Phase 4: Enterprise Scale** | **2026-12-22 Onwards** | Days 91+ | **20 Dispatches** | 3 | 3 | 7 | 7 | **Enterprise Velocity**: Permanent high-scale authority engine publishing 20 deep, runnable engineering dispatches daily. |

### ⚡ Detailed Cycle Breakdown Across Phases:
* **Cycle 1: AI Workflows** (`cat_id = 1`, route `/workflow/{slug}`, 1,200–1,500 words) — Multi-file runnable architecture, DAG graphs, stateful agent loops, failure recovery.
* **Cycle 2: MCP Directory** (`cat_id = 5`, route `/mcp-directory/{slug}`, 1,200–1,500 words) — FastMCP servers, custom tools, STDIO/SSE/JSON-RPC protocols, Zod schemas.
* **Cycle 3: AI Blogs** (`cat_id = 3` or `10`, route `/blogs/{slug}`, 1,200–1,500 words) — Benchmark showdowns, token economics, latency profiling, production trade-offs.
* **Cycle 4: Latest AI News** (`cat_id = 11`, route `/blogs/{slug}`, 1,200–1,500 words) — Breaking model releases, enterprise architecture shifts, agentic security disclosures.

---

## 🚫 ZERO DUPLICATION & GOOGLE SEARCH CONSOLE IMMUNITY POLICY

To permanently eliminate Google Search Console **"Discovered - currently not indexed"** and **"Duplicate without user-selected canonical"** errors:

1. **Strictly Zero Numeric Suffix Slugs**:
   - Slugs ending in `-[0-9]+` (e.g., `-2`, `-3`, `-4`) are **STRICTLY PROHIBITED**.
   - If a topic or slug already exists in any form, **DO NOT append a number**. Discard the candidate topic immediately and research a completely distinct, orthogonal topic.
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

## ✍️ THE ANTI-AI HUMAN WRITING MANIFESTO (GOOGLE HELPFUL CONTENT COMPLIANCE)

Google's Helpful Content System and Core Updates aggressively penalize generic AI-generated content. To guarantee high E-E-A-T and undeniable human craftsmanship, every dispatch MUST strictly adhere to the following 6 writing rules:

### 1. 🚫 The Banned AI Clichés & Buzzwords Blacklist
The following words and structures are **STRICTLY PROHIBITED**. Articles containing them will fail pre-publish audit:
* **Banned Verbs & Adjectives**: `delve`, `tapestry`, `beacon`, `testament to`, `treasure trove`, `game-changer`, `revolutionize`, `plethora`, `multifaceted`, `paramount`, `pivotal`, `crucial role`, `harness the power of`, `embark on a journey`, `seamlessly integrates`, `robust solution`, `at the forefront`.
* **Banned Synthetic Transitions**: `Furthermore`, `Moreover`, `In conclusion`, `To wrap up`, `All in all`, `It's worth noting`, `Needless to say`, `In essence`.
* **Banned Generic Introductions**: `In today's fast-paced digital world`, `In the ever-evolving landscape of artificial intelligence`, `AI has taken the world by storm`, `Imagine a world where...`.
* **Banned Hollow Summaries**: Bullet points that state obvious common sense without technical numbers or specific configurations.

### 2. 👨‍💻 The First-Person Engineering Rule (Lived Experience & Friction)
Real human experts write with friction, skepticism, and hard-earned production scars. Every dispatch MUST be written from the first-person perspective of **Deepak Bagada** (Founder & Editor-in-Chief, CEO at SaaSNext):
* **Mandatory Production War Stories (At Least 2 Per Article)**:
  1. *A real debugging war story*: Detail a specific failure mode encountered during testing (e.g., an exact unhandled Python exception, a token memory leak, a deadlock in multi-agent loops, or an unexpected 429 rate limit spike).
  2. *A concrete dollar-and-cent or latency benchmark*: Mention real cost implications (e.g., *"Our OpenAI bill spiked $240 during overnight testing because the fallback retry loop lacked jitter..."*).
  3. *Specific environment quirks*: Cite exact dependency incompatibilities (e.g., *"Pydantic v2.8 schema validation breaks if you pass nested tool calls without `extra='allow'`"*).

### 3. 📉 Technical Skepticism & "When NOT to Use This"
AI blindly hypes every tool. Senior engineers are critical and realistic. Every dispatch MUST include a dedicated subsection:
* **"When NOT to Use This Pattern"** or **"Production Bottlenecks & Architectural Trade-offs"**.
* Be honest about where the tool fails: latency penalties, concurrency limits, database connection exhaustion, or high maintenance overhead.

### 4. ⚡ Burstiness & Sentence Rhythm Variation
AI text has monotonous, predictable sentence length (uniform 15–20 words). Human writing has high **burstiness** and **perplexity**:
* Mix extremely short, punchy sentences (*"Don't do this." / "Here is why." / "The latency was unacceptable."*) with detailed, technical explanations.
* Use direct, conversational engineer-to-engineer phrasing (*"Here's the catch," "Let's be clear," "Why does this matter?"*).

### 5. 🛠️ Multi-File Runnable Production Code (Zero Toy Examples)
* Never write fake or trivial `foo()` / `bar()` snippets.
* Always present complete, runnable implementations across multiple files with clear file headers:
  * `config.py` (Environment variables, Pydantic settings, API timeouts)
  * `server.py` or `agent.py` (Core logic with try/except, exponential backoff, structured logging)
  * `requirements.txt` or `pyproject.toml` (Pinned dependency versions)
* Provide copy-paste terminal commands (`uv pip install`, `pnpm add`).

### 6. 👤 Author Profile: Deepak Bagada
* **Identity**: Founder & Editor-in-Chief at Daily AI World, CEO at SaaSNext.
* **Credentials**: Full-stack cloud architect, high-concurrency systems engineer, builder of agentic workflows and production SaaS platforms.
* **Byline format**:
  `By <a href="https://x.com/deeepakbagada" rel="author">Deepak Bagada</a>, Founder & Editor-in-Chief at Daily AI World.`
* **Social links**: [@deeepakbagada](https://x.com/deeepakbagada) & [https://deepakbagada.in](https://deepakbagada.in)

---

## 🤖 GOOGLE AI OVERVIEW & GENERATIVE ENGINE OPTIMIZATION (AEO / GEO)

### A. The "AEO Direct Answer Box" (First 80–120 Words)
Directly under the H1 / introduction:
1. Provide a direct 2-sentence technical definition or answer that AI crawlers can quote directly.
2. Present a bulleted summary of the 3 primary architectural facts or metrics.
3. Zero fluff or filler introductions (avoid "In today's fast-paced world...").
4. **NO "## AEO Direct Answer Box" heading** — render directly in prose.

### B. High-Density Semantic Triples & Entity Anchoring
* Ground entity relationships: `[Subject] [Predicate] [Object]`.
* Explicitly cite software versions and hardware configurations (`Python 3.12`, `Node v22`, `PostgreSQL 16`, `NVIDIA H100`).

### C. Structured Markdown Tables & Step-by-Step Matrices
* **At least 1 Comparative Benchmark Table**: Real-world metrics (latency ms, cost per 1M tokens, throughput req/sec).
* **Numbered Implementation Steps**: Clear, ordered technical steps (`Step 1: Setup`, `Step 2: Core Server`, `Step 3: Verification`).

---

## 🔗 DYNAMIC LIVE HTTP 200 INTERNAL LINK WEAVING

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

## 📄 DISPATCH JSON SCHEMA

```json
{
  "title": "string (50-65 chars, clean high-CTR editorial, STRICTLY ZERO SQUARE BRACKETS [])",
  "seo_title": "string (50-60 chars, keyword-first, no brackets, ending with | Daily AI World)",
  "meta_description": "string (strictly 145-158 chars, active verb, primary keyword, direct AEO answer, high CTR)",
  "seo_keywords": "string (comma-separated, 5-8 high-intent keywords)",
  "category_id": 1,
  "author_id": 1,
  "deck": "string (strictly 145-158 chars, identical to meta_description for seamless Blade SERP display)",
  "ai_summary": "string (structured 2-3 sentence AEO summary for search & AI crawlers)",
  "excerpt": "string (concise 1-sentence card preview, 80-110 chars)",
  "content": "string (full Markdown body, strictly 1,200-1,500 words, first-person engineering voice, production war stories, AEO direct answer block, 3-5 verified internal links, runnable multi-file code, benchmark tables, NO raw script tags, NO duplicate FAQ headings)",
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

## 🛠️ EXECUTION & QUALITY AUDIT SCRIPTS

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
   *Validates: ZERO square brackets in title/seo_title/meta_description, mandatory 140–160 char meta_description, deck synchronization, word count (1,200–1,500), anti-duplicate FAQ check, anti-AI buzzword filter (bans delve, tapestry, game-changer, etc.), first-person engineering voice check, 3–5 verified internal links against Hostinger DB, no numeric slug suffixes, live DB anti-duplication guard, factual integrity & anti-hallucination filter, accredited author attribution (Deepak Bagada).*

4. **Direct Publish to Live Hostinger Database (`srv1334.hstgr.io`)**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/publish_single_article.php /path/to/dispatch.json
   ```
   *Directly inserts into Live Hostinger Database (`srv1334.hstgr.io`) as primary, rejects duplicate slugs/titles, square brackets, and numeric suffixes, synchronizes deck with meta_description for clean Blade rendering, automatically assigns Deepak Bagada (`author_id = 1`), paces publishing timestamp, and makes article immediately live without touching Git.*

5. **Live URL Quality & Layout Audit**:
   ```bash
   php /Users/deepakbagada/personal/Daily\ AI\ world/scripts/audit_live_url.php "https://dailyaiworld.com/workflow/my-slug"
   ```
   *Validates: HTTP 200 OK, author byline (Deepak Bagada), body length, >=3 internal links, single FAQ accordion rendering, zero duplicate FAQ blocks.*

---

## 🔄 THE 4-CYCLE SEQUENTIAL ONE-BY-ONE EXECUTION PROTOCOL

When the user invokes this skill:
1. **DETERMINE TODAY'S PHASE & QUOTA**:
   - Check current calendar date and calculate `days_elapsed = (current_date - 2026-09-22)`.
   - **Phase 1 (Days 1–30 | Sep 22 – Oct 22, 2026)**: Target **6 Dispatches** (1 Workflow, 1 MCP, 2 Blogs, 2 News).
   - **Phase 2 (Days 31–60 | Oct 23 – Nov 21, 2026)**: Target **10 Dispatches** (2 Workflows, 2 MCP, 3 Blogs, 3 News).
   - **Phase 3 (Days 61–90 | Nov 22 – Dec 21, 2026)**: Target **16 Dispatches** (2 Workflows, 2 MCP, 6 Blogs, 6 News).
   - **Phase 4 (Days 91+ | Dec 22, 2026 Onwards)**: Target **20 Dispatches** (3 Workflows, 3 MCP, 7 Blogs, 7 News).
2. Execute the 4 cycles in strict sequential order for today's quota. Each article must be searched, written, audited, pushed to DB, and verified live **individually before moving to the next item**:

```
========================================================================================
CYCLE 1: AI WORKFLOWS (Category ID: 1, Canonical: /workflow/{slug})
========================================================================================
For each Item in Cycle 1 (Phase 1: 1 item | Phase 2 & 3: 2 items | Phase 4: 3 items):
  1. SEARCH:
     - Run `search_web` for a trending AI Workflow architecture, agent loop, or orchestration release.
     - Formulate a clean, high-CTR editorial title with ZERO square brackets:
       (e.g. `Multi-Agent DAG Orchestration with LangGraph: 68% Cost Drop and Zero Token Waste`).
  2. PRE-CHECK DUPLICATE:
     - Check `memory.md` (both workspace & config).
     - Run Hostinger DB collision query via CLI. Ensure zero duplicate & clean slug (no numeric suffix).
  3. FETCH LINKS:
     - Run `php scripts/get_verified_internal_links.php` to obtain 3–5 guaranteed live links.
  4. WRITE:
     - Write complete JSON payload (`workflow_dispatch_X.json`):
       * Title: Clean, high-CTR, strictly NO square brackets.
       * SEO Title: 50–60 chars, keyword-first, ends with `| Daily AI World`.
       * Meta Description: Strictly 145–158 characters with active verb hook and primary keyword.
       * Deck: Exact same 145–158 character text as meta_description.
       * Word count: strictly 1,200 to 1,500 words.
       * First-person voice of Deepak Bagada (Founder & Editor-in-Chief).
       * At least 2 production war stories / real debugging logs / latency or dollar metrics.
       * Multi-file runnable code (`config.py`, `workflow.py`, `requirements.txt`).
       * Dwell-time ASCII / Mermaid flow diagram.
       * AEO answer block in first 80-120 words (prose only, NO heading).
       * 3-5 verified internal links woven into body.
       * Zero FAQ headings in Markdown content body.
       * Interactive FAQs array (3-4 technical Q&As).
       * Author signature matching Deepak Bagada.
  5. PRE-PUBLISH AUDIT:
     - Run `php scripts/audit_dispatch_payload.php workflow_dispatch_X.json`.
     - If failed: Fix title / meta description / word count / links immediately and re-audit until PASSED.
  6. DIRECT DB PUSH:
     - Run `php scripts/publish_single_article.php workflow_dispatch_X.json`.
     - Direct push to Hostinger Live DB (`srv1334.hstgr.io`). Zero git push.
  7. LIVE URL AUDIT:
     - Run `php scripts/audit_live_url.php <live_url>`.
     - Confirm HTTP 200 OK, Deepak Bagada byline, FAQ accordion rendering, zero duplicate FAQs.
  8. MEMORY LOG:
     - Append published record to both local `memory.md` and config `memory.md`.
  9. REPEAT:
     - Proceed to next item in Cycle 1.

========================================================================================
CYCLE 2: MCP DIRECTORY (Category ID: 5, Canonical: /mcp-directory/{slug})
========================================================================================
For each Item in Cycle 2 (Phase 1: 1 item | Phase 2 & 3: 2 items | Phase 4: 3 items):
  1. SEARCH:
     - Run `search_web` for a trending MCP server, tool integration, or Model Context Protocol innovation.
     - Formulate a clean, high-CTR title with ZERO square brackets:
       (e.g. `Build a FastMCP SQLite Server with 42ms Response Times and Zero Overhead`).
  2. PRE-CHECK DUPLICATE:
     - Check `memory.md` and Hostinger DB collision query. Ensure zero collision & clean slug.
  3. FETCH LINKS:
     - Run `php scripts/get_verified_internal_links.php` for 3-5 verified live links.
  4. WRITE:
     - Write complete JSON payload (`mcp_dispatch_X.json`) following all Anti-AI Manifesto rules, clean title (no brackets), 145–158 char meta description & deck, multi-file FastMCP server code, Zod schemas, Cursor/Claude integration, 1,200–1,500 words, Deepak Bagada author attribution.
  5. PRE-PUBLISH AUDIT:
     - Run `php scripts/audit_dispatch_payload.php mcp_dispatch_X.json`. Fix any errors.
  6. DIRECT DB PUSH:
     - Run `php scripts/publish_single_article.php mcp_dispatch_X.json`.
  7. LIVE URL AUDIT:
     - Run `php scripts/audit_live_url.php <live_url>`. Verify HTTP 200 OK.
  8. MEMORY LOG:
     - Update both `memory.md` files.
  9. REPEAT:
     - Proceed to next item in Cycle 2.

========================================================================================
CYCLE 3: AI BLOGS (Category ID: 3 or 10, Canonical: /blogs/{slug})
========================================================================================
For each Item in Cycle 3 (Phase 1: 2 items | Phase 2: 3 items | Phase 3: 6 items | Phase 4: 7 items):
  1. SEARCH:
     - Run `search_web` for trending LLM benchmarks, token economics, coding agent evaluations, or architecture comparisons.
     - Formulate a clean, high-CTR title with ZERO square brackets:
       (e.g. `Claude 3.7 Sonnet vs GPT-4.5: Terminal Benchmark Showdown and Token Economics`).
  2. PRE-CHECK DUPLICATE:
     - Check `memory.md` and Hostinger DB collision query.
  3. FETCH LINKS:
     - Run `php scripts/get_verified_internal_links.php` for 3-5 verified live links.
  4. WRITE:
     - Write complete JSON payload (`blog_dispatch_X.json`) with clean title, 145–158 char meta description & deck, deep technical benchmarks, token economics tables, latency profiling, failure analysis, 1,200–1,500 words, Deepak Bagada voice.
  5. PRE-PUBLISH AUDIT:
     - Run `php scripts/audit_dispatch_payload.php blog_dispatch_X.json`. Fix any errors.
  6. DIRECT DB PUSH:
     - Run `php scripts/publish_single_article.php blog_dispatch_X.json`.
  7. LIVE URL AUDIT:
     - Run `php scripts/audit_live_url.php <live_url>`. Verify HTTP 200 OK.
  8. MEMORY LOG:
     - Update both `memory.md` files.
  9. REPEAT:
     - Proceed to next item in Cycle 3.

========================================================================================
CYCLE 4: LATEST AI NEWS (Category ID: 11, Canonical: /blogs/{slug})
========================================================================================
For each Item in Cycle 4 (Phase 1: 2 items | Phase 2: 3 items | Phase 3: 6 items | Phase 4: 7 items):
  1. SEARCH:
     - Run `search_web` for breaking, factual AI news from the last 24-48 hours (model releases, frontier lab announcements, open-weight weights drops, enterprise security shifts). Verify against real sources.
     - Formulate a clean, high-CTR title with ZERO square brackets:
       (e.g. `Cloudera x Mistral: Private Frontier Inference Meets Governed Enterprise Data`).
  2. PRE-CHECK DUPLICATE:
     - Check `memory.md` and Hostinger DB collision query.
  3. FETCH LINKS:
     - Run `php scripts/get_verified_internal_links.php` for 3-5 verified live links.
  4. WRITE:
     - Write complete JSON payload (`news_dispatch_X.json`) with clean title, 145–158 char meta description & deck, architectural impact analysis, benchmark breakdown, migration guide, 1,200–1,500 words, Deepak Bagada voice.
  5. PRE-PUBLISH AUDIT:
     - Run `php scripts/audit_dispatch_payload.php news_dispatch_X.json`. Fix any errors.
  6. DIRECT DB PUSH:
     - Run `php scripts/publish_single_article.php news_dispatch_X.json`.
  7. LIVE URL AUDIT:
     - Run `php scripts/audit_live_url.php <live_url>`. Verify HTTP 200 OK.
  8. MEMORY LOG:
     - Update both `memory.md` files.
  9. REPEAT:
     - Proceed to next item in Cycle 4.
```

---

## 📋 FINAL RUN VERIFICATION REPORT

At the completion of the 4 cycles for today's active phase (Phase 1: 6 articles | Phase 2: 10 articles | Phase 3: 16 articles | Phase 4: 20 articles), generate a comprehensive verification report:

- **Active Phase & Date**: e.g. Phase 1 (Day X/30) | Quota: 6 Dispatches
- **Total Dispatches Published**: Confirmed exact count published to Hostinger Live DB.
- **4-Cycle Verification Table**:
  | Cycle | # | Category | Clean Editorial Title (Zero Brackets) | Meta Description (145–158 chars) | Slug | Word Count | Internal Links | Live URL | Live Status |
  |---|---|---|---|---|---|---|---|---|---|
  | Cycle 1 | 1 | AI Workflows | `Multi-Agent DAG Orchestration...` | `Build multi-agent DAG pipelines with...` | `...` | 1,350 | 4 Links | `https://dailyaiworld.com/workflow/...` | 200 OK |
  | Cycle 1 | 2 | AI Workflows | `Autonomous Code Review Workflow...` | `Deploy an autonomous code review...` | `...` | 1,410 | 4 Links | `https://dailyaiworld.com/workflow/...` | 200 OK |
  | Cycle 2 | 1 | AI Tools (MCP) | `Build a FastMCP SQLite Server...` | `Learn how to build a FastMCP SQLite...` | `...` | 1,320 | 3 Links | `https://dailyaiworld.com/mcp-directory/...` | 200 OK |
  | Cycle 2 | 2 | AI Tools (MCP) | `Hardened MCP Gateway Playbook...` | `Secure 200+ agent tools with Zod...` | `...` | 1,380 | 4 Links | `https://dailyaiworld.com/mcp-directory/...` | 200 OK |
  | Cycle 3 | 1 | Coding / LLMs | `Claude 3.7 Sonnet vs GPT-4.5...` | `Benchmark Claude 3.7 Sonnet against...` | `...` | 1,440 | 5 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 3 | 2 | Coding / LLMs | `Agent Memory Architecture in 2026...` | `Compare episodic, vector, and graph...` | `...` | 1,310 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 3 | 3 | Coding / LLMs | `DeepSeek V4 Flash Codex Pro...` | `Evaluate DeepSeek V4 Flash Codex Pro...` | `...` | 1,390 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 3 | 4 | Coding / LLMs | `Price per Task vs Price per Token...` | `Analyze real-world Databricks agent...` | `...` | 1,420 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 3 | 5 | Coding / LLMs | `Context Compression Algorithms...` | `Compare prompt caching and eviction...` | `...` | 1,360 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 3 | 6 | Coding / LLMs | `Speculative Decoding in Production...` | `Evaluate draft model latency drops...` | `...` | 1,330 | 5 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 1 | AI News | `Cloudera x Mistral: Private Frontier...`| `Explore how Cloudera and Mistral bring...` | `...` | 1,280 | 3 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 2 | AI News | `OpenAI Ships GPT-6 Astra...` | `Discover OpenAI GPT-6 Astra reasoning...` | `...` | 1,340 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 3 | AI News | `Anthropic Unveils Tool Search GA...` | `Analyze Anthropic Tool Search GA with...` | `...` | 1,305 | 3 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 4 | AI News | `Google Releases Gemini 3.7 Flash...` | `Review Gemini 3.7 Flash coding standard...`| `...` | 1,350 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 5 | AI News | `Meta Llama 4 Scout Weights Released...` | `Explore Meta Llama 4 Scout architecture...` | `...` | 1,380 | 4 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
  | Cycle 4 | 6 | AI News | `Cursor Ships Background Agent Cloud...` | `Inspect Cursor Background Agent Cloud...` | `...` | 1,290 | 3 Links | `https://dailyaiworld.com/blogs/...` | 200 OK |
- **Zero Square Brackets Policy**: Confirmed 100% clean of `[ ]` across all 16 live titles and SEO titles.
- **Strict Meta Description & Deck Sync**: Confirmed all 16 dispatches have verified 145–158 character meta descriptions synchronized with deck to prevent Blade truncation.
- **Zero Duplicate FAQs**: Confirmed 100% clean Blade accordion rendering across all 16 live URLs.
- **Zero Numeric Suffix Slugs**: Confirmed all 16 slugs are clean semantic strings without `-[0-9]+`.
- **Sole Author Attribution**: Confirmed Deepak Bagada (`author_id = 1`) across all 16 live dispatches.
- **Memory Synchronized**: Confirmed both workspace and config `memory.md` logged all 16 articles.
