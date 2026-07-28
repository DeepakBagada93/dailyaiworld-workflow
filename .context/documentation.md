# Daily AI World — Platform Documentation

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
