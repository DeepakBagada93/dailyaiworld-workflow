# Daily AI World — Platform Documentation (Final, Enhanced)

**Version:** 1.1 (adds Revenue Architecture to the original v1.0 platform spec)
**Status:** Production-track — Laravel Edition

---

## 1. Executive Summary & Brand Purpose

**Daily AI World** is an ultra-premium, independent artificial intelligence journal and editorial platform built for:
- AI Founders
- Software Developers & ML Engineers
- SaaS Builders
- Business Professionals & Enterprise Executives

**Tagline**: *AI Workflows, Tools & Insights for Builders.*
**Primary Author**: Deepak Bagada (`CEO, SaaSNext`)

The application is engineered with a **typography-first, minimal, calm, and trustworthy editorial design language**, drawing aesthetic inspiration from Forbes, Bloomberg, Stripe Press, and The Information, with an enterprise CMS inspired by Linear, Notion, and Vercel.

---

## 2. Technology Stack & Framework Specifications

- **Backend Framework**: Laravel 13 (PHP 8.4+)
- **Database Engine**: MySQL 8 (`daily_ai_world` database)
- **Frontend Architecture**: Blade Templates, Alpine.js, Tailwind CSS v4 (`@tailwindcss/vite`)
- **Asset Pipeline**: Vite v8
- **Authentication**: Laravel Breeze + Sanctum for REST APIs
- **Queue & Scheduler**: Database queue driver & Laravel Scheduler (`php artisan schedule:run`)
- **REST APIs**: Versioned JSON API (`/api/v1/...`) with API Resources

---

## 3. Core Web Architecture & Routing Map

### 3.1 Public Reader Routes (`routes/web.php`)
- `GET /`: Front Page (12-column editorial grid, Hero Dispatch, Key Takeaways, Desk Sections, Market Ticker).
- `GET /article/{slug}`: Ultimate Article Reader (760px prose width, scroll progress bar, sticky share, sticky table of contents, collapsible AI briefing, key takeaways box, FAQ accordions, comments thread).
- `GET /category/{slug}`: Editorial Desk Archive pages (`ai-workflows`, `agentic-ai`, `coding`, `automation`, `ai-tools`, `open-source`, `business`, `startups`, `productivity`, `llms`, `ai-news`, `tutorials`).
- `GET /search`: Search Archive with filter pills and pagination.
- `GET /bookmarks`: Saved Reading List.
- `POST /bookmarks/{article}/toggle`: Interactive bookmark toggle.
- `POST /article/{article}/comments`: Reader commentary submission.
- `POST /newsletter/subscribe`: Daily executive briefing subscription handler.
- `GET /design-system`: Living Design System Showcase.

### 3.2 Enterprise CMS Routes (`/cms/*`)
- `/cms`: Executive Dashboard (Linear-style metrics, velocity, live queue).
- `/cms/posts`: Story Archive (Bulk actions, status tabs).
- `/cms/posts/create`: Notion/Linear Block Editor with autosave simulation.
- `/cms/drafts`: Drafts Queue.
- `/cms/scheduled`: Scheduled Dispatches.
- `/cms/categories`: Desk & Tag Management.
- `/cms/authors`: Columnist Roster & Profiles.
- `/cms/media`: Media Library & Asset Pipeline.
- `/cms/seo`: SEO Rules & Schema Markup.
- `/cms/analytics`: Readership & Traffic Analytics.
- `/cms/ai-studio`: AI Content Studio & Prompt Library.
- `/cms/research-queue`: arXiv & Silicon Signals Queue.
- `/cms/internal-linking`: Cross-Reference Topic Graph.
- `/cms/deployment`: Vercel / Hostinger CI/CD Deployment Logs.
- `/cms/settings`: System Preferences.

### 3.3 REST API Endpoints (`routes/api.php`)
- `GET /api/v1/articles`: Paginated JSON feed of articles with category & author objects.
- `GET /api/v1/articles/{slug}`: Article detail JSON.
- `GET /api/v1/categories`: List of desks with article counts.
- `GET /api/v1/categories/{slug}`: Single category JSON.
- `POST /api/v1/newsletter/subscribe`: API newsletter subscriber registration.

---

## 4. Database Architecture & Models

35 Production Database Tables:
- `users`: User profiles, roles, credentials.
- `roles`: `Admin`, `Editor`, `Author`, `Subscriber`, `Guest`.
- `permissions`: System privileges.
- `role_user`, `permission_role`: Pivot tables.
- `authors` & `authors_prod`: Columnist profiles (default: **Deepak Bagada · CEO, SaaSNext**).
- `categories`: Editorial desks (`accent_color`, `icon`, `is_featured`).
- `posts` & `articles`: Editorial stories (`title`, `slug`, `deck`, `content`, `excerpt`, `ai_summary`, `tier`, `reading_time`, `key_takeaways`, `faqs`, `view_count`, `published_at`).
- `post_categories`, `post_tags`: Pivot tables.
- `comments`: Reader commentary & moderation queue.
- `bookmarks`: Saved reading lists per user/session.
- `market_indices`: Ticker data (MMLU-Pro, H100 SXM, B200, AI-INDEX).
- `newsletters` & `newsletter_subscribers`: Email briefing lists.
- `seo_meta`, `internal_links`, `redirects`, `faqs_prod`, `schemas`, `prompts`, `prompt_categories`, `ai_generations`, `research_topics`, `trend_sources`, `published_logs`, `activity_logs`, `settings`, `menus`, `pages`, `contacts`.

---

## 5. Automated Console Commands

- `php artisan app:setup-db`: Automated MySQL database connection check, database creation (`daily_ai_world`), and seeding.
- `php artisan import:blogs`: Automated parser importing 800+ blog posts from `blogs_rows.sql` into MySQL `articles` and `posts` tables.

---

## 6. Revenue Architecture (New)

Daily AI World's editorial positioning (Forbes / Bloomberg / Stripe Press tone) supports a **premium, low-clutter monetization model** rather than a high-volume ad-network approach. The `posts.tier` field already anticipates this — the plan below builds it out fully.

### 6.1 Monetization fit for this platform
Because the site reads as a serious editorial publication (not a listicle directory), the highest-fit revenue streams are ones that preserve editorial trust:

| Stream | Fit | Why |
|---|---|---|
| Sponsored Dispatches (labeled sponsor content) | High | Matches existing `tier` field and Blade article template; feels native to an editorial format |
| Executive Newsletter Sponsorships | High | `newsletters` / `newsletter_subscribers` tables already exist — this is the lowest-lift stream to ship first |
| Premium/Subscriber Tier (paywalled deep-dives, `ai_generations` research digests) | Medium-High | `roles` already includes `Subscriber`; a paid tier is a natural extension, not a new system |
| Sponsor Logo / Partner Rail on category pages | Medium | Passive, low editorial risk, easy to sell alongside Sponsored Dispatches |
| Display Advertising | Low | Would undercut the premium/calm design language — use only as filler once other streams are established, if at all |
| Affiliate links in tool/workflow-related articles | Medium | Contextual, works well in `ai-tools` / `automation` desks specifically |

### 6.2 Realistic revenue expectations by traffic stage
| Stage | Readership | Primary revenue | Realistic monthly range |
|---|---|---|---|
| Seed (current) | Early impressions, 800+ imported posts live | Newsletter list-building only | $0 |
| Growth | 10K–50K monthly readers | 1-2 newsletter sponsors, first Sponsored Dispatch | $200–$2,000 |
| Established | 50K–200K monthly readers | Recurring newsletter sponsors + subscriber tier | $2,000–$15,000 |
| Authority | 200K+ monthly readers, cited as a trade press source | Multiple sponsor tiers + paid subscriptions + data/research syndication | $15,000–$75,000+ |

A premium editorial brand generally converts *slower* than a raw directory but at a *higher trust ceiling* — sponsors pay more to be associated with a publication that reads as credible, and readers tolerate fewer, better-placed sponsors rather than many banner ads.

---

## 7. New/Updated Database Tables (extends Section 4)

| Table | Purpose |
|---|---|
| `sponsors` | Sponsor company records: `name`, `logo_path`, `website_url`, `contact_email`, `status` |
| `sponsorships` | Join table linking `sponsors` to placements: `sponsor_id`, `placement_type` (`newsletter` / `dispatch` / `category_rail`), `article_id` (nullable), `start_date`, `end_date`, `price_paid`, `impressions`, `clicks` |
| `subscriptions` | Paid subscriber records: `user_id`, `plan` (`monthly`/`annual`), `status`, `stripe_subscription_id`, `current_period_end` |
| `affiliate_links` | `article_id`, `label`, `url`, `disclosure_text`, `click_count` |
| `sponsor_reports` | Auto-generated monthly performance snapshots per `sponsor_id` (impressions, clicks, CTR) for renewal conversations |

`posts.tier` (existing field) is extended in usage (not schema) to also gate premium content: `free` / `premium` / `sponsored`.

---

## 8. New Routes (extends Section 3)

### 8.1 Public
- `GET /advertise`: Sponsor pitch page — rate card, past sponsor logos, lead form.
- `GET /subscribe`: Premium subscription plan page (Stripe Checkout handoff).
- `POST /subscribe/checkout`: Stripe Checkout session creation.
- `POST /stripe/webhook`: Subscription lifecycle webhook handler (`subscriptions` table sync).
- Article Reader (`/article/{slug}`) gains a **paywall gate**: if `posts.tier = premium` and the reader has no active `subscriptions` row, show the excerpt + a subscribe CTA in place of full `content`.

### 8.2 CMS (`/cms/*`)
- `/cms/sponsors`: Sponsor CRM — create/edit `sponsors`, manage `sponsorships`, view auto-generated `sponsor_reports`.
- `/cms/subscriptions`: Subscriber list, churn view, MRR summary (reads from `subscriptions`).
- `/cms/monetization`: Executive revenue dashboard — MRR, sponsorship revenue this month, affiliate click revenue, all in one Linear-style summary view alongside the existing `/cms/analytics`.

### 8.3 REST API
- `GET /api/v1/sponsors`: Public sponsor/partner list (for the `/advertise` social-proof rail).
- `POST /api/v1/subscriptions/webhook`: Mirrors the Stripe webhook for headless/mobile clients if needed later.

---

## 9. New Console Commands (extends Section 5)

- `php artisan sponsorships:expire`: Cron-runnable — flips `sponsorships.status` to `expired` once `end_date` passes and removes the placement from live rails.
- `php artisan sponsorships:report`: Generates the monthly `sponsor_reports` row per active sponsor from `impressions`/`clicks` data.
- `php artisan subscriptions:sync`: Reconciles local `subscriptions` state against Stripe on schedule, catching any missed webhooks.

---

## 10. Rollout Sequencing

1. **Now:** Confirm `newsletters`/`newsletter_subscribers` capture is live site-wide (it's already in the schema — make sure the signup UI is prominent on `/` and at the end of every article).
2. **Now:** Add `affiliate_links` to `ai-tools` and `automation` desk articles — zero traffic threshold needed, passive once written.
3. **At first meaningful newsletter list (500+ subs) or ~10K monthly readers:** Ship `/advertise`, `sponsors`/`sponsorships` tables, and `/cms/sponsors`. Start with direct outreach to tool vendors already covered editorially — warm outreach converts far better than a cold rate card at this stage.
4. **At ~50K monthly readers:** Introduce the `subscriptions` premium tier — gate deep-dive research/analysis pieces (not daily news) behind it, since that's the content type readers pay for in this niche.
5. **At authority stage:** Formalize `/cms/monetization` as the standing revenue dashboard, and consider research/data syndication deals leveraging `research_topics` / `ai_generations` as a distinct B2B revenue line.

---

*Sections 1–5 preserve the original v1.0 platform specification unchanged. Sections 6–10 are new in v1.1.*