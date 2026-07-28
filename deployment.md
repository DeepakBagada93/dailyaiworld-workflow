# Production Deployment Guide — Daily AI World

This guide covers deploying **Daily AI World** to production environments (Hostinger, Cloud VPS, AWS, or DigitalOcean).

---

## 🚀 Pre-Deployment Requirements

- PHP 8.4+ CLI and FPM installed on target server.
- MySQL 8.0+ instance.
- Composer 2.x & Node.js 20+.
- SSL Certificate (Let's Encrypt / Hostinger SSL).

---

## 📦 Deployment Commands Sequence

```bash
# 1. Clone repository from GitHub
git clone https://github.com/your-org/daily-ai-world.git .

# 2. Install production PHP dependencies
composer install --no-dev --optimize-autoloader

# 3. Install & build frontend production assets
npm install
npm run build

# 4. Copy and configure environment settings
cp production.env.example .env
php artisan key:generate

# 5. Execute production migrations and seeders
php artisan migrate --force --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Optimize application caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Restart queue workers (if active)
php artisan queue:restart
```

---

## ⚡ Cache Invalidation & Maintenance

Whenever pushing new updates from GitHub:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
