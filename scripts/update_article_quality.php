<?php

/**
 * Daily AI World — Article Quality Batch Updater
 * Updates title, content, and internal links in both Hostinger Live DB and Local DB.
 *
 * Usage:
 *   php scripts/update_article_quality.php --file=scratch/batch1_updates.json
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

config([
    'database.connections.hostinger' => [
        'driver'    => 'mysql',
        'host'      => 'srv1334.hstgr.io',
        'port'      => '3306',
        'database'  => 'u775719140_dailyai',
        'username'  => 'u775719140_admin',
        'password'  => 'Dailyaiworld@3093',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'options'   => [ \PDO::ATTR_TIMEOUT => 8 ],
    ]
]);

$options = getopt('', ['file:']);
if (empty($options['file'])) {
    echo "Usage: php scripts/update_article_quality.php --file=<path_to_json>\n";
    exit(1);
}

$filePath = $options['file'];
if (!file_exists($filePath)) {
    echo "Error: File {$filePath} not found.\n";
    exit(1);
}

$updates = json_decode(file_get_contents($filePath), true);
if (!is_array($updates)) {
    echo "Error: Invalid JSON array in {$filePath}\n";
    exit(1);
}

echo "Loaded " . count($updates) . " updates from {$filePath}\n";

$connections = ['hostinger', 'mysql'];

foreach ($updates as $idx => $item) {
    $slug = $item['slug'] ?? null;
    if (!$slug) continue;

    $fields = [];
    if (isset($item['title'])) $fields['title'] = $item['title'];
    if (isset($item['content'])) $fields['content'] = $item['content'];
    if (isset($item['deck'])) $fields['deck'] = $item['deck'];
    if (isset($item['excerpt'])) $fields['excerpt'] = $item['excerpt'];
    $fields['updated_at'] = now();

    if (empty($fields)) continue;

    echo "[" . ($idx + 1) . "/" . count($updates) . "] Updating slug: {$slug}...\n";

    foreach ($connections as $conn) {
        try {
            $affected = DB::connection($conn)->table('articles')
                ->where('slug', $slug)
                ->update($fields);
            echo "   -> {$conn}: " . ($affected ? "Updated ({$affected} row)" : "No change/Not found") . "\n";
        } catch (\Throwable $e) {
            echo "   ❌ Error updating {$conn}: " . $e->getMessage() . "\n";
        }
    }
}

echo "\nAll updates completed successfully.\n";
