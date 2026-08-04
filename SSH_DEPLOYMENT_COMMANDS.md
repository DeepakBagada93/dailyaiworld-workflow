# Daily AI World — Hostinger SSH Deployment Commands

Run these commands **one by one** in your Hostinger SSH terminal.

---

## Step 1: Navigate to App Directory

```bash
cd ~/public_html
```

---

## Step 2: Verify .env Database Config

```bash
cat .env | grep DB_
```

**Expected output:**
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u775719140_dailyai
DB_USERNAME=u775719140_admin
DB_PASSWORD=your_password
```

**If DB_HOST shows `127.0.0.1`, fix it:**
```bash
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=localhost/' .env
```

---

## Step 3: Fix File & Folder Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R $(whoami):$(whoami) storage bootstrap/cache
```

---

## Step 4: Generate APP_KEY (if missing)

```bash
php artisan key:generate
```

---

## Step 5: Create Storage Symlink (for images)

```bash
php artisan storage:link
```

---

## Step 6: Clear All Cached Config

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Step 7: Test Database Connection

```bash
php artisan db:show
```

If this shows your tables list — database is connected.
If it says **Access denied** — your password in `.env` is wrong. Fix it and re-run Step 6.

---

## Step 8: Cache Everything for Production Speed

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 9: Set APP_DEBUG to false

```bash
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
php artisan config:cache
```

---

## Step 10: Verify Site is Live

```bash
curl -I https://dailyaiworld.com
```

**Expected:** `HTTP/2 200`

---

## Troubleshooting

### Still getting 500 error?
```bash
tail -50 storage/logs/laravel.log
```
This shows the exact error with file and line number.

### Still getting 429 Too Many Requests?
```bash
php artisan cache:clear
```
Wait 60 seconds and refresh.

### Database Access Denied?
1. Go to **Hostinger hPanel → Databases → MySQL Databases**
2. Find user `u775719140_admin` → click **⋮** → **Change Password**
3. Copy new password into `.env`:
```bash
nano .env
```
4. Update `DB_PASSWORD=new_password_here`, save (Ctrl+O, Enter, Ctrl+X)
5. Then run:
```bash
php artisan config:clear
php artisan config:cache
```

---

## One-Liner (Run All Fix Commands at Once)

```bash
cd ~/public_html && sed -i 's/DB_HOST=127.0.0.1/DB_HOST=localhost/' .env && chmod -R 755 storage bootstrap/cache && php artisan key:generate --force && php artisan storage:link && php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```
