# Complete Hostinger Deployment & 500 Server Error Resolution Guide

This document provides a step-by-step blueprint to resolve **500 Internal Server Errors**, set up the **MySQL Database in phpMyAdmin**, configure the **`.env` file**, set correct **file permissions**, and deploy **Daily AI World** seamlessly on Hostinger.

---

## 🛠️ Step 1: Fix 500 Internal Server Error (Root Cause Checklist)

A **500 Server Error** in Laravel on Hostinger is almost always caused by one of these 4 issues:

### 1. Missing `.env` File or `APP_KEY`
Laravel cannot run without an encryption key (`APP_KEY`).
- In Hostinger File Manager (`public_html`), make sure a file named `.env` exists.
- Ensure `APP_KEY` is populated (e.g. `APP_KEY=base64:3S3z0KxQ81d2Kx+E7U8g1z2b3c4d5e6f7g8h9i0j1k2=`).

### 2. Incorrect Database Credentials
If `.env` database parameters do not match your Hostinger MySQL database name, user, or password, Laravel fails to connect and throws a 500 error.

### 3. File & Folder Permissions (`storage` & `bootstrap/cache`)
Laravel requires read/write access to `storage/` and `bootstrap/cache/`.
- In Hostinger File Manager or SSH, set folder permissions for `storage` and `bootstrap/cache` to **`775`** (or `755`).

### 4. PHP Version Mismatch
- Go to Hostinger **hPanel** -> **Advanced** -> **PHP Configuration**.
- Ensure PHP version is set to **PHP 8.2** or **PHP 8.3**.

---

## 🗄️ Step 2: Create & Import MySQL Database on Hostinger

### 2.1 Create MySQL Database & User in Hostinger
1. Log in to **Hostinger hPanel** -> **Databases** -> **MySQL Databases**.
2. Your database details (already created):
   - **MySQL Database Name**: `u775719140_dailyai`
   - **MySQL Username**: `u775719140_admin`
   - **Password**: *(your password — keep it safe)*
3. If not yet created, click **Create**.

### 2.2 Import `daily_ai_world_import.sql.gz` via phpMyAdmin
1. In Hostinger hPanel -> **Databases** -> **phpMyAdmin** -> Click **Enter phpMyAdmin** next to your new database.
2. Click the **Import** tab in the top navigation bar.
3. Click **Choose File** and select **`hostinger_import.sql.gz`** (located in your repository root — this file is pre-configured for your `u775719140_dailyai` database).
4. Leave all default options as UTF-8 / Automatic.
5. Scroll down and click **Go** (or **Import**).
6. Wait 10-20 seconds. You will see a success message: *Import has been successfully finished*.

---

## ⚙️ Step 3: Configure `.env` Environment File

1. In Hostinger hPanel -> **Files** -> **File Manager** -> Open `public_html`.
2. Locate `production.env.example` and rename/copy it to **`.env`**.
3. Edit `.env` and fill in your exact Hostinger details:

```env
APP_NAME="Daily AI World"
APP_ENV=production
APP_KEY=base64:3S3z0KxQ81d2Kx+E7U8g1z2b3c4d5e6f7g8h9i0j1k2=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://yourdomain.com

LOG_CHANNEL=daily
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u775719140_dailyai
DB_USERNAME=u775719140_admin
DB_PASSWORD=your_actual_hostinger_db_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=editor@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="editor@yourdomain.com"
MAIL_FROM_NAME="Daily AI World"
```

---

## 🚀 Step 4: Hostinger SSH / Terminal Execution (Final Optimization)

If you have Hostinger SSH / Terminal access:

```bash
# 1. Navigate to your app directory
cd ~/public_html

# 2. Clear stale cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 3. Create storage symlink for images
php artisan storage:link

# 4. Cache production routes and config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If you do NOT have SSH access:
- The included `.htaccess` automatically routes requests to `/public/`.
- All CSS/JS assets are pre-compiled in `public/build/`.

---

## ⏱️ Step 5: Hostinger Cron Job Setup (Laravel Scheduler)

In Hostinger hPanel -> **Advanced** -> **Cron Jobs**:

- **Frequency**: Every minute (`* * * * *`)
- **Command**:
  ```bash
  /usr/bin/php /home/u123456789/public_html/artisan schedule:run >> /dev/null 2>&1
  ```
  *(Replace `/home/u123456789/` with your exact Hostinger account username)*

---

## 🔍 How to Debug Remaining 500 Errors
If you still see a 500 error after following these steps:
1. Temporarily open `.env` in Hostinger File Manager.
2. Change `APP_DEBUG=false` to `APP_DEBUG=true`.
3. Refresh your website. Laravel will show the exact line and error traceback.
4. Open `storage/logs/laravel.log` to view the detailed stack trace.
5. Once resolved, change `APP_DEBUG=false` back to protect your server.
