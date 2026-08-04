# Hostinger Deployment Guide — Ready for `public_html` & phpMyAdmin

This repository is **100% configured** for instant deployment on Hostinger Web Hosting, Cloud Hosting, or any cPanel shared hosting environment.

---

## 🚀 3-Step Hostinger Deployment Instructions

### Step 1: Deploy Repository to Hostinger (`public_html`)

1. Log in to **Hostinger hPanel** -> Go to **Advanced** -> **Git**.
2. Click **Create a new repository**:
   - **Repository URL**: `https://github.com/DeepakBagada93/dailyaiworld-workflow.git`
   - **Branch**: `main`
   - **Directory**: `public_html`
3. Click **Create** and then **Deploy**.

> ℹ️ *Note*: The root `.htaccess` in this repository automatically routes all incoming web traffic to the `/public` directory. Pre-compiled production assets (`public/build`) are included in git, so no `npm build` server commands are required!

---

### Step 2: Import Database into Hostinger phpMyAdmin

1. In Hostinger hPanel -> Go to **Databases** -> **MySQL Databases**.
2. Create a new database (e.g. `u123456789_daily_ai`) and create a database user & password.
3. Open **phpMyAdmin** for that database.
4. Click the **Import** tab at the top.
5. Click **Choose File** and select `daily_ai_world_import.sql.gz` from the repository.
6. Click **Go** (bottom right).
7. All 53 tables and 800+ articles will import cleanly without errors!

---

### Step 3: Configure `.env` Environment File

1. In Hostinger hPanel -> Go to **Files** -> **File Manager** -> Open `public_html`.
2. Copy `production.env.example` to `.env`.
3. Update the database credentials with your Hostinger MySQL details:

```env
APP_NAME="Daily AI World"
APP_ENV=production
APP_KEY=base64:3S3z0KxQ81d2Kx+E7U8g1z2b3c4d5e6f7g8h9i0j1k2=
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_daily_ai
DB_USERNAME=u123456789_admin
DB_PASSWORD=your_hostinger_database_password
```

---

## ⏱️ Hostinger Cron Job Setup (Laravel Scheduler)

In Hostinger hPanel -> **Cron Jobs**:

- **Timing**: Every minute (`* * * * *`)
- **Command**:
  ```bash
  /usr/bin/php /home/u123456789/public_html/artisan schedule:run >> /dev/null 2>&1
  ```
  *(Replace `/home/u123456789/` with your exact Hostinger home directory path)*

---

## ✅ Deployment Checklist

- [x] Pre-compiled assets included in `/public/build` (Space Grotesk typography, Tailwind CSS 4, Alpine.js).
- [x] Root `.htaccess` for automatic `/public/` directory routing.
- [x] 100% complete MySQL database dump ready in `daily_ai_world_import.sql.gz` for phpMyAdmin.
- [x] Production `.env` template in `production.env.example`.
