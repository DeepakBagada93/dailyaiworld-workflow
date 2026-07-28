# Hostinger Specific Deployment & Cron Configuration

This document contains exact configurations for deploying **Daily AI World** directly to Hostinger Web Hosting or Cloud Hosting.

---

## 📁 1. Directory & Symlink Setup

On Hostinger, the web root is typically `public_html`. You have two options:

### Option A: Point Domain Document Root to `public` (Recommended)
In Hostinger hPanel -> **Subdomains / Domains** -> Change document root to:
`/public_html/public`

### Option B: Apache `.htaccess` Redirection
If you cannot change the document root, place this `.htaccess` file inside `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^$ public/ [L]
    RewriteRule (.*) public/$1 [L]
</IfModule>
```

---

## ⏱️ 2. Hostinger Cron Job Setup (Laravel Scheduler)

In Hostinger hPanel -> **Cron Jobs**:

- **Frequency**: Every minute (`* * * * *`)
- **Command**:
  ```bash
  /usr/bin/php /home/u123456789/public_html/artisan schedule:run >> /dev/null 2>&1
  ```
  *(Replace `/home/u123456789/public_html/` with your exact Hostinger path)*

---

## 🔄 3. Hostinger Queue Worker Setup

For handling newsletter emails and AI summaries in the background:

- **Command**:
  ```bash
  /usr/bin/php /home/u123456789/public_html/artisan queue:work --stop-when-empty
  ```
- Set this cron job to run every 5 minutes (`*/5 * * * *`).

---

## 🔒 4. Production Security Check

1. Ensure `APP_DEBUG=false` in Hostinger `.env`.
2. Verify directory permissions:
   - `storage/` -> `775`
   - `bootstrap/cache/` -> `775`
