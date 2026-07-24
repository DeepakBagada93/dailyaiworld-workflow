<?php
/**
 * Hostinger High-Performance Config Snippet
 * Add these constants to your wp-config.php above the line:
 * /* That's all, stop editing! Happy publishing. */

// 1. Enable LiteSpeed & Page Caching
define('WP_CACHE', true);

// 2. Redis Object Cache Configuration (Hostinger hPanel Redis)
define('WP_REDIS_HOST', '127.0.0.1');
define('WP_REDIS_PORT', 6379);
define('WP_REDIS_TIMEOUT', 1);
define('WP_REDIS_READ_TIMEOUT', 1);
define('WP_REDIS_DATABASE', 0);
define('WP_REDIS_MAXTTL', 86400);

// 3. Database & Garbage Collection Optimizations
define('WP_POST_REVISIONS', 3);        // Limit revisions per post to 3 to prevent DB bloat
define('AUTOSAVE_INTERVAL', 180);       // Autosave every 3 minutes instead of 60 seconds
define('EMPTY_TRASH_DAYS', 7);          // Empty trash every 7 days

// 4. Memory Allocations for High Speed
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// 5. Disable File Editing inside WP Admin (Security + Speed)
define('DISALLOW_FILE_EDIT', true);

// 6. Automatic Cleanups
define('MEDIA_TRASH', true);
