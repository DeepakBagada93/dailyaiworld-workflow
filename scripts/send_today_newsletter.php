<?php

/**
 * Daily AI World — Send Today's Newsletter Digest to Active Subscribers via Brevo
 * Usage: php scripts/send_today_newsletter.php [--live] [--date=YYYY-MM-DD]
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

$isLive = in_array('--live', $argv);

$targetDate = '2026-09-01';
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--date=')) {
        $targetDate = substr($arg, 7);
    }
}

echo "===================================================\n";
echo " Daily AI World — Newsletter Dispatcher (Brevo)\n";
echo " Date Target: {$targetDate}\n";
echo " Mode: " . ($isLive ? "LIVE PRODUCTION SEND" : "DRY RUN / PREVIEW") . "\n";
echo "===================================================\n\n";

// 1. Fetch Today's Published Articles from Hostinger DB
$host = "srv1334.hstgr.io";
$db   = "u775719140_dailyai";
$user = "u775719140_admin";
$pass = "Dailyaiworld@3093";

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10,
    ]);
} catch (\Exception $e) {
    echo "⚠️ Primary host {$host} failed, trying fallback IP...\n";
    $pdo = new PDO("mysql:host=193.203.184.64;dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10,
    ]);
}

$stmt = $pdo->prepare("
    SELECT id, category_id, title, slug, excerpt, deck, reading_time, published_at 
    FROM articles 
    WHERE published_at >= :target_start AND published_at <= :target_end
    ORDER BY id ASC
");
$stmt->execute([
    'target_start' => "{$targetDate} 00:00:00",
    'target_end'   => "{$targetDate} 23:59:59",
]);
$rawArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Deduplicate by title to ensure clean newsletter
$articles = [];
$seenTitles = [];
foreach ($rawArticles as $art) {
    $titleKey = trim($art['title']);
    if (!isset($seenTitles[$titleKey])) {
        $seenTitles[$titleKey] = true;
        
        $catId = (int) $art['category_id'];
        $slug = $art['slug'];
        $urlPath = match ($catId) {
            1 => "/workflow/{$slug}",
            5 => "/mcp-directory/{$slug}",
            default => "/blogs/{$slug}",
        };
        
        $art['url'] = "https://dailyaiworld.com" . $urlPath;
        $art['deck'] = !empty($art['deck']) ? $art['deck'] : (!empty($art['excerpt']) ? $art['excerpt'] : 'Read full dispatch on Daily AI World.');
        $articles[] = $art;
    }
}

$articleCount = count($articles);
echo "Found {$articleCount} unique articles published for {$targetDate}:\n";
foreach ($articles as $idx => $art) {
    $num = str_pad($idx + 1, 2, ' ', STR_PAD_LEFT);
    echo " [{$num}] (Cat: {$art['category_id']}) {$art['title']}\n";
}
echo "\n";

if ($articleCount === 0) {
    echo "❌ No articles found for {$targetDate}. Aborting dispatch.\n";
    exit(1);
}

// 2. Fetch Active Subscribers from Hostinger DB
$subStmt = $pdo->query("
    SELECT id, email, edition, status, created_at 
    FROM newsletter_subscribers 
    WHERE status = 'active'
    ORDER BY id ASC
");
$subscribers = $subStmt->fetchAll(PDO::FETCH_ASSOC);
$totalSubscribers = count($subscribers);

echo "Found {$totalSubscribers} active subscribers in database.\n\n";

$formattedDate = date('F j, Y', strtotime($targetDate));
$subjectTitle = "⚡ Daily AI World: {$articleCount} Breakthrough AI Dispatches, Workflows & MCP Servers (" . date('M d, Y', strtotime($targetDate)) . ")";

$data = [
    'appName' => 'Daily AI World',
    'editionName' => 'Daily Executive Briefing',
    'issueDate' => $formattedDate,
    'subjectTitle' => $subjectTitle,
    'siteUrl' => 'https://dailyaiworld.com',
    'articles' => $articles,
];

// 3. Dispatch Emails
$sentCount = 0;
$failedCount = 0;
$logDetails = [];

echo "Starting dispatch sequence...\n";
echo "---------------------------------------------------\n";

foreach ($subscribers as $idx => $sub) {
    $subNum = str_pad($idx + 1, 3, ' ', STR_PAD_LEFT);
    $email = trim($sub['email']);
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "[{$subNum}/{$totalSubscribers}] ⚠️ Skipping invalid email: '{$email}'\n";
        $failedCount++;
        $logDetails[] = [
            'id' => $sub['id'],
            'email' => $email,
            'status' => 'INVALID_EMAIL',
            'time' => date('Y-m-d H:i:s'),
        ];
        continue;
    }

    echo "[{$subNum}/{$totalSubscribers}] Sending to: {$email} ... ";
    
    if (!$isLive) {
        echo "✅ [DRY RUN - OK]\n";
        $sentCount++;
        $logDetails[] = [
            'id' => $sub['id'],
            'email' => $email,
            'status' => 'DRY_RUN_SUCCESS',
            'time' => date('Y-m-d H:i:s'),
        ];
        continue;
    }

    try {
        Mail::send('emails.daily-digest', $data, function ($message) use ($email, $subjectTitle, $targetDate) {
            $message->to($email)
                    ->subject($subjectTitle);
            
            // Brevo Tracking and Campaign Headers
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailin-Tag', "daily-digest-{$targetDate}");
            $headers->addTextHeader('X-Mailin-Custom', json_encode([
                'edition' => 'Daily Executive Briefing',
                'date'    => $targetDate,
            ]));
        });
        
        echo "✅ SENT\n";
        $sentCount++;
        $logDetails[] = [
            'id' => $sub['id'],
            'email' => $email,
            'status' => 'SENT',
            'time' => date('Y-m-d H:i:s'),
        ];
        
        // Delay (200ms) to respect Brevo SMTP throughput
        usleep(200000);
    } catch (\Throwable $e) {
        echo "❌ FAILED: " . $e->getMessage() . "\n";
        $failedCount++;
        $logDetails[] = [
            'id' => $sub['id'],
            'email' => $email,
            'status' => 'FAILED',
            'error' => $e->getMessage(),
            'time' => date('Y-m-d H:i:s'),
        ];
    }
}

echo "\n===================================================\n";
echo " 📊 DISPATCH REPORT SUMMARY\n";
echo "===================================================\n";
echo " Target Date:              {$targetDate} ({$formattedDate})\n";
echo " Total Dispatches In Email: {$articleCount} articles\n";
echo " Total Subscribers:        {$totalSubscribers}\n";
echo " Successfully Dispatched:  {$sentCount}\n";
echo " Failed / Skipped:         {$failedCount}\n";
echo " Delivery Rate:            " . ($totalSubscribers > 0 ? round(($sentCount / $totalSubscribers) * 100, 2) : 0) . "%\n";
echo " Brevo Campaign Tag:       daily-digest-{$targetDate}\n";
echo "===================================================\n";

