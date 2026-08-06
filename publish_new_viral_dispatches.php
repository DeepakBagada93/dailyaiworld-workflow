<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\ArticlePublishingService;

$dispatches = json_decode(file_get_contents(__DIR__ . '/new_viral_payload.json'), true);
$service = new ArticlePublishingService();

echo "========================================\n";
echo "PUBLISHING 8 NEW VIRAL DISPATCHES VIA SERVICE\n";
echo "========================================\n";

$publishedCount = 0;

foreach ($dispatches as $index => $data) {
    $num = $index + 1;
    $wordCount = str_word_count(strip_tags($data['content'] ?? ''));
    echo "[$num/8] {$data['title']} ($wordCount words)\n";

    $result = $service->publish($data);

    if ($result['local_status'] || $result['remote_status']) {
        echo "  [SUCCESS] Local: " . ($result['local_status'] ? 'YES' : 'NO') . " | Remote: " . ($result['remote_status'] ? 'YES' : 'NO') . "\n";
        echo "  [LIVE URL] {$result['live_url']}\n";
        $publishedCount++;
    } else {
        echo "  [ERROR] Failed to publish article.\n";
    }
}

echo "========================================\n";
echo "SUCCESSFULLY PUBLISHED $publishedCount / 8 DISPATCHES TO DUAL DB\n";
echo "========================================\n";
