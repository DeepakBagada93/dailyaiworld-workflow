# Daily AI World — Ultra-Premium Minimalist AI Journal & Realtime Intelligence

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-[#38BDF8]?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Typography](https://img.shields.io/badge/Typography-Space_Grotesk-6D28D9?style=for-the-badge)](https://fonts.google.com/specimen/Space+Grotesk)
[![Accessibility](https://img.shields.io/badge/Accessibility-WCAG_2.1_AAA-22C55E?style=for-the-badge)](https://www.w3.org/WAI/standards-guidelines/wcag/)

> **Daily AI World** is an executive-grade, text-first minimalist magazine journal designed for AI founders, developers, SaaS builders, and tech leaders. It delivers real-time dispatches, agentic workflow breakdowns, frontier compute research, and SaaS architecture analysis with high-contrast readability and zero visual clutter.

---

## 🌟 Key Features & Design System

### 📰 1. Minimalist Magazine Layout Architecture
- **Edition Masthead Banner**: Displays edition issue metadata (`VOL. 26 · ISSUE 04`), date dispatches, and realtime status.
- **Asymmetric Lead Cover Feature**: Prominent lead story layout featuring a Space Grotesk headline, subdeck excerpt, executive key takeaways box, non-clipped author signature pill, and direct audio narration trigger.
- **The Issue Index**: Numerical story directory (`01`, `02`, `03`...) rendered in large semi-transparent Space Grotesk figures.
- **100% Text-First Aesthetic**: All article cards and desk categories focus purely on sharp typography, hairline rules (`divide-[#E9D5FF]`), and reading clarity without unnecessary hero image distractions.

### 🎨 2. Pure White & Royal Purple Palette
- **Canvas Background**: Crisp Pure White (`#FFFFFF`).
- **Cards & Surfaces**: Light ice-lavender blocks (`#FAF5FF`, `#F5F3FF`) framed with soft purple hairline borders (`#E9D5FF`).
- **Headlines & Text**: Midnight Purple (`#1E1B4B`) and Slate (`#374151`) with strict 100% WCAG 2.1 AAA contrast compliance.
- **Brand Accents**: Royal Purple (`#6D28D9`), Vivid Violet (`#7C3AED`), and Deep Purple (`#5B21B6`).

### 🔤 3. Global Space Grotesk Typography
- Integrated **Space Grotesk** (weights 300 to 700) globally across `--font-sans`, `--font-serif`, `body`, headings (`h1` through `h6`), navigation links, and article card titles.

### ⌨️ 4. Dynamic Hero Animations
- **Typewriter Text Loop**: Dynamic live typing & deleting effect (`initTypewriter()`) cycling through key focus topics (*"Building Next-Gen AI Workflows..."*, *"Frontier Compute & Agentic Systems..."*, *"Scaling LLM Architectures in 2026..."*).
- **Interactive SVG Motion Graphic**: Vector SVG neural network node graphic with animated dashed path connections (`.animate-svg-dash`) and rotating orbital ring artwork (`.animate-orbital-spin`).

### ♿ 5. 100% WCAG 2.1 AAA Accessibility
- **Skip Navigation Link**: Accessible keyboard trigger (`Skip to main content`) directing focus immediately to `#main-content`.
- **Landmark Navigation & ARIA Polish**: Explicit `role="main"`, `aria-label`, `aria-expanded`, and live screen-reader announcements (`aria-live="polite"`).
- **Floating Preference Control Panel (`<x-accessibility-widget />`)**:
  - **Text Resizing**: Scale text dynamically (100%, 115%, 125%).
  - **High Contrast Mode**: High-visibility contrast override theme.
  - **Accessible Font Mode**: Dyslexic-friendly letter & line spacing.
  - **Reduced Motion Support**: Respects `@media (prefers-reduced-motion: reduce)`.
- **Focus Rings**: High-visibility 3px focus outline rings (`:focus-visible`).
- **Non-Clipped Author Avatars**: Applied `shrink-0 aspect-square object-cover author-avatar-img` with initial fallback badges (e.g. `D` for Deepak Bagada).

### ⚡ 6. Interactive Reading & Navigation Tools
- **Sticky Reading Progress Bar**: Real-time scroll depth progress indicator at the top of the viewport.
- **Global Search Modal (`⌘K` or `/`)**: Instant article search with quick tag filters.
- **Sticky Audio Player (`a`)**: Audio narration player with speed control (1x, 1.25x, 1.5x, 2x).
- **Keyboard Shortcuts Reference (`?`)**: Modal cheat sheet detailing all keyboard shortcuts.

---

## 🛠️ Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Framework** | [Laravel 12+](https://laravel.com) |
| **Language** | PHP 8.5+ |
| **Styling** | [Tailwind CSS 4](https://tailwindcss.com) & Custom CSS Tokens |
| **Reactivity** | [Alpine.js 3.x](https://alpinejs.dev) |
| **Build Tool** | [Vite 8](https://vitejs.dev) |
| **Typography** | [Space Grotesk](https://fonts.google.com/specimen/Space+Grotesk) & JetBrains Mono |
| **Database** | MySQL / SQLite |

---

## 🚀 Quick Start & Local Setup

### Prerequisites
- PHP `>= 8.2`
- Composer
- Node.js `>= 18` & npm

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/DeepakBagada93/dailyaiworld-workflow.git
   cd dailyaiworld-workflow
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run Database Migrations & Seeders**:
   ```bash
   php artisan migrate --seed
   ```

6. **Build Frontend Assets**:
   ```bash
   npm run build
   ```

7. **Start Development Servers**:
   ```bash
   # Terminal 1: Start Laravel Server
   php artisan serve

   # Terminal 2: Start Vite Dev Server
   npm run dev
   ```

   Visit `http-[#]127.0.0.1:8000` in your browser.

---

## ⌨️ Global Keyboard Shortcuts

| Shortcut | Action |
| :--- | :--- |
| `⌘K` or `/` | Open Search Dialog |
| `a` | Toggle Sticky Narration Audio Player |
| `?` | Open Keyboard Shortcuts Reference |
| `Esc` | Close Active Modal / Overlay |

---

## 👤 Author & License

- **Author**: Deepak Bagada (CEO, SaaSNext)
- **Repository**: [DeepakBagada93/dailyaiworld-workflow](https://github.com/DeepakBagada93/dailyaiworld-workflow)
- **License**: Open-sourced software under the [MIT License](LICENSE).
