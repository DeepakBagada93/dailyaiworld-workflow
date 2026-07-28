# Daily AI World — Design System & Aesthetic Specifications

## 1. Design Aesthetics & Visual Principles

- **Philosophy**: Typography is the hero. Generous whitespace, calm, minimal, high contrast, zero visual clutter, no heavy gradients, focus on trust and authority.
- **Reading Width**: Fixed 760px prose column for optimal reading comfort.
- **Theme**: Crisp, pristine white background (`#FFFFFF`) on public site with restrained purple accents (`#6D28D9`). Vercel dark mode default for Enterprise CMS (`#0B0B0F`).

---

## 2. Color Palette & Token System

```css
:root {
  --color-primary: #6D28D9;         /* Vibrant Purple Accent */
  --color-primary-hover: #7C3AED;   /* Purple Hover */
  --color-accent: #8B5CF6;          /* Light Accent */
  --color-bg-main: #FFFFFF;         /* Pristine White Main Background */
  --color-bg-sec: #FAFAFC;          /* Very Light Lavender Secondary Surface */
  --color-bg-card: #FFFFFF;         /* Card Background */
  --color-bg-muted: #F5F3FF;        /* Muted Highlight Surface */
  --color-border-subtle: #E8E7EF;   /* Subtle Border Divider */
  --color-text-heading: #111827;    /* Deep Charcoal Headings */
  --color-text-body: #4B5563;       /* Comfortable Body Text */
  --color-text-muted: #9CA3AF;      /* Metadata & Captions */
  --color-success: #22C55E;         /* Success Indicators */
  --color-warning: #F59E0B;         /* Warning Badges */
  --color-error: #EF4444;           /* Error Alerts */
}
```

---

## 3. Typography Scale & Fonts

- **Headings**: *Playfair Display* (Serif) — Luxurious, editorial, timeless.
- **Body & Interface**: *Inter* (Sans-serif) — Clean, legible, high reading comfort.
- **Code, Data & Badges**: *JetBrains Mono* (Monospace) — Technical precision.

| Scale Token | Font Family | Size | Weight | Line Height |
| :--- | :--- | :--- | :--- | :--- |
| `Hero Headline` | Playfair Display | `3rem` – `3.75rem` (48-60px) | `800` Extrabold | `1.08` |
| `Article Title` | Playfair Display | `1.875rem` – `2.5rem` (30-40px) | `700` Bold | `1.15` |
| `Section Title` | Playfair Display | `1.5rem` – `1.875rem` (24-30px) | `700` Bold | `1.2` |
| `Sub-heading (H3)` | Playfair Display | `1.25rem` – `1.5rem` (20-24px) | `600` Semibold | `1.25` |
| `Body Text` | Inter | `1rem` – `1.125rem` (16-18px) | `400` Regular | `1.75` |
| `Metadata & Badges` | JetBrains Mono | `0.6875rem` – `0.75rem` (11-12px) | `500`/`700` | `1.4` |

---

## 4. Header & Navigation Specifications

- **Header Height**: Fixed `72px` on Desktop (`h-[72px]`), `64px` on Mobile (`h-[64px]`).
- **Header Background**: Pure white (`bg-[#FFFFFF] border-b border-[#E8E7EF] shadow-sm`).
- **Brand Logo**: Rounded black square container (`w-9 h-9 rounded-lg bg-black`) with a **purple inverted triangle SVG icon** (`#8B5CF6`).
- **Fixed Navigation Items**:
  1. `Workflows` (`/category/ai-workflows`)
  2. `Insights` (`/`)
  3. `Categories` (`/category/coding`)
  4. `Community` (`/bookmarks`)
  5. `Tools` (`/category/ai-tools`)
- **Right Utilities**: Search (⌘K), Bookmarks counter, Sign In / Portal button.

---

## 5. Footer & Copyright Specifications

- **Copyright**: `© Daily AI World. Built by Deepak Bagada · CEO, SaaSNext`
- **Sections**: Company, Editorial, Resources, Legal, Social.
- **Newsletter Box**: Full-width executive briefing capture box with Alpine.js success feedback state.

---

## 6. Micro-Animations & Interactivity

- **Bookmark Toggle**: Scale pulse animation (`scale-125 transition-all`) when toggling reading list items.
- **Focus Rings**: Accessible purple focus rings (`focus:ring-2 focus:ring-[#6D28D9] focus:outline-none`) on all interactive buttons, links, and forms.
- **Card Hover Effects**: Subtle border shift to purple (`hover:border-purple-300 transition-all duration-200`).
