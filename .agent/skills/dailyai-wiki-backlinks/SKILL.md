---
name: dailyai-wiki-backlinks
description: >
  Autonomous high-authority Wikipedia backlink & citation discovery skill for Daily AI World (dailyaiworld.com).
  Identifies Wikipedia claims with {{Citation needed}} and broken {{Dead link}} tags across Artificial Intelligence,
  LLMs, Machine Learning, Multi-Agent Systems, Retrieval-Augmented Generation, and Model Context Protocol.
  Connects to Hostinger MySQL live database (u775719140_dailyai) to semantically match empirical benchmarks,
  architectural guides, and technical breakdowns authored by Deepak Bagada to unverified Wikipedia claims.
  Generates 100% policy-compliant Wikipedia wikitext markup (<ref>{{cite web ...}}</ref>) adhering strictly to
  WP:RS (Reliable Sources), WP:NPOV (Neutral Point of View), and WP:DEADREF. Ensures zero-reversion citations
  that elevate Daily AI World into Google's Knowledge Graph, Perplexity/ChatGPT training corpora, and establish
  top-tier Domain Authority (DA 98 entity trust).
---

# 🌐 Daily AI World — Autonomous Wikipedia Backlink Engine v1.0
### (DA 98 Entity Citation Engine | Knowledge Graph Injection | Generative Engine Optimization [GEO] & AEO Visibility | WP:RS & WP:DEADREF Compliant)

> [!IMPORTANT]
> **WHY WIKIPEDIA BACKLINKS ARE THE HIGHEST VALUE ASSET FOR DAILY AI WORLD:**
> While Wikipedia external links carry `rel="nofollow"`, they provide 3 indispensable algorithmic advantages:
> 1. **Knowledge Graph & Entity Authority:** Google, Perplexity, ChatGPT, Claude, and Gemini use Wikipedia as their primary factual baseline. Being cited in Wikipedia establishes `dailyaiworld.com` as a verified primary source in Knowledge Graphs.
> 2. **Crawl Acceleration:** Googlebot crawls Wikipedia continuously 24/7. Any URL cited on Wikipedia is prioritized for recrawls, helping eliminate holding queues ("Crawled - currently not indexed").
> 3. **The Secondary Citation Multiplier:** Tech journalists, researchers, and bloggers cite Wikipedia reference footnotes in their articles, resulting in dozens of organic, `dofollow` backlinks across the web.

---

## 1. Core Wikipedia Policies & Compliance Matrix

Every proposed citation must comply strictly with Wikipedia's community standards to ensure it is never flagged, reverted, or blacklisted:

| Policy | Requirement | Daily AI World Implementation |
| :--- | :--- | :--- |
| **WP:RS (Reliable Sources)** | Citations must back factual claims with verifiable data. | We match technical claims with 1,200–1,500 word empirical articles featuring reproducible code and benchmark data authored by Deepak Bagada. |
| **WP:NPOV (Neutral Point of View)** | Citations must not read like advertisements. | We never link to promotional landing pages. We cite specific technical breakdowns, benchmarks, and architectural workflows. |
| **WP:DEADREF** | Replace broken/dead links with active equivalents. | We locate `{{Dead link}}` tags on relevant AI pages and provide an active, permanent replacement URL from `dailyaiworld.com`. |
| **WP:COI (Conflict of Interest)** | Avoid disruptive self-promotion. | We target genuine citation gaps where the Wikipedia article is actively missing a source (`{{Citation needed}}`). We recommend 1 single citation per article maximum. |

---

## 2. The 4-Phase Operational Execution Loop

```
┌────────────────────────────────────────────────────────────────────────┐
│              WIKIPEDIA CITATION ACQUISITION PIPELINE                   │
├────────────────────────────────────────────────────────────────────────┤
│                                                                        │
│  PHASE 1: LIVE WIKIPEDIA SCOUTING                                      │
│  • Scan Wikipedia MediaWiki API for target AI pages.                   │
│  • Extract exact paragraphs tagged with {{Citation needed}} or         │
│    {{Dead link}}.                                                      │
│                                                                        │
│  PHASE 2: HOSTINGER DB SEMANTIC MATCHING                               │
│  • Query published articles from live Hostinger DB (author_id = 1).    │
│  • Calculate semantic keyword overlap score between Wikipedia claim    │
│    and Daily AI World articles (title, slug, excerpt, body).           │
│                                                                        │
│  PHASE 3: COMPLIANT WIKITEXT & EDIT SUMMARY GENERATION                 │
│  • Render {{cite web}} markup with exact author, title, date, URL.     │
│  • Draft encyclopedic edit summary citing WP:RS or WP:DEADREF.         │
│                                                                        │
│  PHASE 4: DEPLOYMENT & TRACKING                                        │
│  • Present ready-to-paste snippet with exact target sentence.          │
│  • Log opportunity and deployment status to tracker.json.              │
└────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Automation Scripts & CLI Commands

### Command 1: Run Full Topic Scan
Scans Wikipedia’s core AI pages (`Large language model`, `Retrieval-augmented generation`, `Vector database`, `Prompt engineering`, `Artificial general intelligence`) and matches against the latest published articles in Hostinger Live DB:

```bash
php .agent/skills/dailyai-wiki-backlinks/scripts/wiki_scout.php --limit=5
```

### Command 2: Scan for a Specific Wikipedia Page
```bash
php .agent/skills/dailyai-wiki-backlinks/scripts/wiki_scout.php --topic="Vector database"
```

### Command 3: Find Wikipedia Citation Opportunities for a Specific Article ID
```bash
php .agent/skills/dailyai-wiki-backlinks/scripts/wiki_scout.php --article-id=2647
```

---

## 4. Citation Markup Standard

All citations generated by this skill follow the official Wikipedia `{{cite web}}` parameter contract:

```wikitext
<ref>{{cite web |url=https://dailyaiworld.com/blogs/example-slug |title=Article Title |author=Bagada, Deepak |publisher=Daily AI World |date=YYYY-MM-DD |access-date=YYYY-MM-DD}}</ref>
```

### Approved Edit Summaries:
* For Dead Link Replacements:
  `Replaced dead external link with active technical documentation per WP:DEADREF`
* For Citation Needed Fulfillments:
  `Added verifiable empirical benchmark source per WP:RS`
* For Protocol Specifications:
  `Added technical architectural reference for protocol specification per WP:RS`

---

## 5. Account Warming & Safe Deployment Protocol

To ensure your Wikipedia editor account retains high trust:
1. **Never edit while logged out (IP edits have high scrutiny).** Create a registered Wikipedia user account.
2. **Warm the account:** Make 5–10 minor typo fixes, grammar corrections, or dead link cleanups across unrelated non-tech articles first (e.g. historical, geography, or science articles).
3. **Pacing:** Apply no more than 1–2 technical citations per week. Do not mass-edit 10 pages in one afternoon.
4. **Strict Context Adherence:** Only place the `<ref>` tag directly adjacent to the sentence that your Daily AI World article genuinely proves or documents.
