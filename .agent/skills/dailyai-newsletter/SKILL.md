---
name: dailyai-newsletter
description: >
  Autonomous executive dark-theme newsletter dispatch & subscriber growth skill for Daily AI World (dailyaiworld.com).
  Searches, filters, and audits subscribers from Hostinger DB, renders high-converting cyber-minimalist dark-theme
  HTML briefings, and dispatches high-CTR daily digests via Brevo SMTP with delivery throttling, viral sharing loops,
  and zero-spam primary-inbox deliverability.
---

# 📬 Daily AI World — Executive Dark-Theme Newsletter Engine
### (High-CTR Dark Briefings · Subscriber Intelligence · Viral Referral & Traffic Growth Loops)

> [!IMPORTANT]
> **PRIMARY MISSION**:  
> 1. Deliver high-signal, zero-fluff engineering digests to Daily AI World executives and developers.  
> 2. Maximize open rates (target >45%) and click-through rates (CTR >18%) using executive cyber-minimalist dark theme styling.  
> 3. Drive consistent referral traffic and subscriber list growth via embedded viral share loops (X, LinkedIn, coworker email forwards).  
> 4. Guarantee 100% primary inbox deliverability via Brevo SMTP with 150ms connection throttling.

---

## 🛠️ CORE CAPABILITIES & CLI CONTROLS

All newsletter operations are executed through the unified dispatcher script:
`/Users/deepakbagada/personal/Daily AI world/scripts/send_dark_newsletter.php`

### 1. 🔍 Subscriber Search & Audit Mode
Quickly query and inspect subscribers across Hostinger Live MySQL (`srv1334.hstgr.io`):
```bash
# Search subscribers by keyword or domain
php scripts/send_dark_newsletter.php --search="gmail"
php scripts/send_dark_newsletter.php --search="saasnext"

# List all active subscribers with ID and joined date
php scripts/send_dark_newsletter.php --list-subscribers
```

### 2. 👁️ Local HTML Preview Generation
Render the complete dark-theme HTML template for a target date into `public/preview-dark-newsletter.html` to inspect visually in a browser without sending emails:
```bash
# Preview today's newsletter in dark theme
php scripts/send_dark_newsletter.php --date=2026-10-15 --html-preview

# Open in default macOS browser
open public/preview-dark-newsletter.html
```

### 3. 🧪 Single-Recipient Test Send (Verification Gate)
Always dispatch a single test email to your phone or desktop before a live run:
```bash
php scripts/send_dark_newsletter.php --date=2026-10-15 --test=ceo@saasnext.in
```

### 4. 🚀 Live Production Dispatch (All Active Subscribers)
Send the verified dark briefing to all active subscribers via Brevo with rate-limiting throttling (150ms per email):
```bash
php scripts/send_dark_newsletter.php --date=2026-10-15 --live

# Or limit to a staged pilot batch (e.g., first 25 subscribers)
php scripts/send_dark_newsletter.php --date=2026-10-15 --live --limit=25
```

---

## 🎨 EXECUTIVE CYBER-MINIMALIST DARK DESIGN SYSTEM

The email template (`resources/views/emails/dark-digest.blade.php`) is designed to look like a high-end terminal IDE briefing, optimized for Apple Mail, Gmail (iOS/Android/Web), and Outlook Dark Mode:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                             DARK THEME PALETTE                              │
├───────────────────┬───────────────────┬─────────────────────────────────────┤
│ Component         │ Hex Color Code    │ Purpose                             │
├───────────────────┼───────────────────┼─────────────────────────────────────┤
│ Outer Wrapper     │ `#08090D`         │ Deepest pitch black background      │
│ Inner Container   │ `#0F1219`         │ Elevated dark slate surface         │
│ Card Surfaces     │ `#121520`         │ Secondary card fill                 │
│ Hero Feature Card │ `#141824`         │ Accentuated top story container     │
│ Borders           │ `#1E2433`         │ Subtle high-contrast card borders   │
│ Primary Text      │ `#F1F5F9`         │ High-contrast crisp off-white       │
│ Muted Body Deck   │ `#94A3B8`         │ Readable low-eye-strain secondary   │
│ Workflow Badge    │ `#A78BFA`         │ Violet accent (Category ID 1)       │
│ MCP Tool Badge    │ `#34D399`         │ Emerald accent (Category ID 5)      │
│ Coding Badge      │ `#38BDF8`         │ Sky blue accent (Category ID 3)     │
│ LLMs Badge        │ `#F472B6`         │ Rose pink accent (Category ID 10)   │
│ AI News Badge     │ `#FBBF24`         │ Amber gold accent (Category ID 11)  │
│ Primary CTA       │ `#2563EB → #1D4ED8`│ High-conversion royal blue gradient │
└───────────────────┴───────────────────┴─────────────────────────────────────┘
```

---

## 🎯 HIGH-CTR SUBJECT LINE FORMULA BANK

To achieve **40% to 55%+ open rates**, subject lines must look like urgent, breaking technical memos rather than promotional marketing blasts:

### Formula 1: The Breaking Metric Hook
* `⚡ Daily AI World: Build an Autonomous Canary Agent — Argo Rollouts + Prometheus (Oct 18)`
* `⚡ Daily AI World: 2.8x vLLM V1 Throughput & PostGIS FastMCP (Oct 19)`

### Formula 2: The Direct Engineering Showdown
* `⚡ Daily AI World: KubeRay vs Celery Swarms: Benchmarking Distributed Agents`
* `⚡ Daily AI World: DSPy Assertions vs Pydantic Retry Loops (64% Token Drop)`

### Formula 3: The Frontier Model Drop
* `⚡ Daily AI World: Meta Launches Muse Wonder ($4/1M) & DeepMind EmbeddingGemma 2`
* `⚡ Daily AI World: OpenAI Launches ChatGPT Space and Always-On "Dots"`

### Banned Subject Line Pitfalls (Triggers Spam & Promotions Tab)
- ❌ **Never use spam triggers**: `Free`, `Act Now`, `Don't Miss`, `Limited Time`, `Exclusive Offer`.
- ❌ **Never use ALL CAPS**: `BREAKING NEWS`, `MUST READ`.
- ❌ **Never use square brackets in subject lines**: `[Newsletter]`, `[Daily Digest]`.

---

## 🔄 VIRAL REFERRAL & SUBSCRIBER GROWTH ENGINE

Every dispatch features an embedded **Viral Growth Box** styled as a native dark component:
1. **1-Click Share to X (Twitter)**:
   - Pre-populates the tweet with the day's top technical takeaway + clean link to `https://dailyaiworld.com`.
2. **1-Click Share to LinkedIn**:
   - Routes to LinkedIn share endpoint with executive briefing context.
3. **Coworker Forward Link**:
   - `mailto:` intent pre-populated with: *"Here is today's technical AI briefing from Daily AI World: https://dailyaiworld.com"*.
4. **UTM Attribution**:
   - All links append `?utm_source=newsletter&utm_medium=email&utm_campaign=daily-dark` to track views, conversion rates, and referral traffic in analytics.

---

## 🛡️ SENDER REPUTATION & DELIVERABILITY PROTOCOL

1. **Brevo SMTP Relay Configuration**:
   - Outgoing credentials configured in `.env` via `smtp-relay.brevo.com` (Port 587, TLS).
   - Sender signature: `Deepak Bagada (ceo@saasnext.in)`.
2. **Rate Limiting Delay**:
   - The script introduces a mandatory `usleep(150000)` (150ms pause) between recipient deliveries. This prevents SMTP socket throttling and keeps IP reputation at 99%+.
3. **Brevo Tracking Headers**:
   - Adds `X-Mailin-Tag: dark-digest-YYYY-MM-DD` and `X-Mailin-Custom` JSON headers for granular open-rate, click-rate, and bounce analytics inside the Brevo dashboard.
4. **Clean Unsubscribe Mechanism**:
   - CAN-SPAM / GDPR compliant one-click unsubscribe links present in every footer.

---

## 📋 STEP-BY-STEP WORKFLOW PROTOCOL

When the user requests to send or prepare a newsletter:

1. **Step 1 — Query Available Articles**:
   - Run `php scripts/send_dark_newsletter.php --date=YYYY-MM-DD --html-preview` to inspect the available dispatches for that day.
2. **Step 2 — Search / Audit Subscriber Count**:
   - Run `php scripts/send_dark_newsletter.php --list-subscribers` to confirm active subscriber count and health.
3. **Step 3 — Send Verification Test Email**:
   - Run `php scripts/send_dark_newsletter.php --date=YYYY-MM-DD --test=<user_email>` to verify rendering on desktop/mobile.
4. **Step 4 — Execute Live Send**:
   - Only upon verification, run `php scripts/send_dark_newsletter.php --date=YYYY-MM-DD --live` to dispatch the briefing to all subscribers.
5. **Step 5 — Generate Summary Report**:
   - Output recipient count, delivered count, delivery rate %, and Brevo campaign tracking tag.
