<?php

/**
 * Daily AI World — Executive Dark Theme Newsletter Dispatcher v2.0
 * Features:
 * 1. Search subscriber emails by keyword/domain (--search="gmail")
 * 2. List subscribers and status breakdown (--list-subscribers)
 * 3. Fetch published articles from Hostinger Remote DB (--date=YYYY-MM-DD)
 * 4. Executive minimal dark theme email rendering (emails.dark-digest)
 * 5. Dry-run and live Brevo SMTP dispatching with throughput throttling
 * 6. HTML preview file generation (--html-preview)
 * 7. Viral referral loops (X, LinkedIn, email forward) to grow subscriber list
 *
 * Usage:
 *   php scripts/send_dark_newsletter.php --list-subscribers
 *   php scripts/send_dark_newsletter.php --search="saasnext"
 *   php scripts/send_dark_newsletter.php --date=2026-10-15 --html-preview
 *   php scripts/send_dark_newsletter.php --date=2026-10-15 --test=ceo@saasnext.in
 *   php scripts/send_dark_newsletter.php --date=2026-10-15 --live
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

$options = getopt('', [
    'live',
    'date::',
    'test::',
    'search::',
    'list-subscribers',
    'limit::',
    'html-preview',
    'help'
]);

if (isset($options['help'])) {
    echo <<<HELP
Daily AI World — Executive Dark Theme Newsletter Dispatcher

Options:
  --list-subscribers     List active subscribers and breakdown
  --search="query"       Search subscribers by email address or domain
  --date=YYYY-MM-DD      Target publication date (default: today)
  --test=email@domain    Send single test email to verify layout
  --live                 Execute live dispatch to all active subscribers via Brevo
  --limit=N              Limit total dispatches to N subscribers
  --html-preview         Generate local HTML preview file in public/preview-newsletter.html

HELP;
    exit(0);
}

$isLive = isset($options['live']);
$targetDate = $options['date'] ?? date('Y-m-d');
$testEmail = isset($options['test']) ? trim($options['test']) : null;
$searchQuery = isset($options['search']) ? trim($options['search']) : null;
$listMode = isset($options['list-subscribers']);
$htmlPreview = isset($options['html-preview']);
$limit = isset($options['limit']) ? (int)$options['limit'] : null;

// Connect to Hostinger Live DB
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
    echo "⚠️ Host {$host} failed, attempting direct IP...\n";
    $pdo = new PDO("mysql:host=193.203.184.64;dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10,
    ]);
}

// 1. Handle Subscriber Search and Listing
if ($listMode || $searchQuery) {
    echo "===================================================\n";
    echo " 👥 Daily AI World — Subscriber Intelligence Radar\n";
    echo "===================================================\n";

    if ($searchQuery) {
        $stmt = $pdo->prepare("SELECT id, email, edition, status, created_at FROM newsletter_subscribers WHERE email LIKE :q ORDER BY id DESC");
        $stmt->execute(['q' => "%{$searchQuery}%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Search results matching '{$searchQuery}' (" . count($results) . " found):\n\n";
    } else {
        $stmt = $pdo->query("SELECT id, email, edition, status, created_at FROM newsletter_subscribers ORDER BY id DESC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Total Registered Subscribers (" . count($results) . " total):\n\n";
    }

    $activeCount = 0;
    foreach ($results as $sub) {
        $statusIcon = ($sub['status'] === 'active') ? '🟢' : '⚪';
        if ($sub['status'] === 'active') $activeCount++;
        echo " {$statusIcon} [#{$sub['id']}] {$sub['email']} ({$sub['status']}) — Joined: {$sub['created_at']}\n";
    }

    echo "\nSummary: " . count($results) . " subscriber(s) listed | Active: {$activeCount}\n";
    echo "===================================================\n";
    if (!$isLive && !$testEmail && !$htmlPreview) {
        exit(0);
    }
}

// 2. Query Articles for Selected Date
$stmt = $pdo->prepare("
    SELECT id, category_id, title, slug, excerpt, deck, reading_time, published_at 
    FROM articles 
    WHERE published_at >= :start AND published_at <= :end
    ORDER BY id ASC
");
$stmt->execute([
    'start' => "{$targetDate} 00:00:00",
    'end'   => "{$targetDate} 23:59:59",
]);
$rawArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fallback to recent published articles if target date has 0
if (count($rawArticles) === 0) {
    echo "⚠️ Notice: No articles found with published_at on {$targetDate}.\n";
    echo "Fetching the latest 6 published dispatches from Hostinger DB as fallback...\n";
    $fallbackStmt = $pdo->query("
        SELECT id, category_id, title, slug, excerpt, deck, reading_time, published_at 
        FROM articles 
        WHERE status = 'published'
        ORDER BY id DESC 
        LIMIT 6
    ");
    $rawArticles = array_reverse($fallbackStmt->fetchAll(PDO::FETCH_ASSOC));
}

$articles = [];
$seenTitles = [];
foreach ($rawArticles as $art) {
    $tKey = trim($art['title']);
    if (!isset($seenTitles[$tKey])) {
        $seenTitles[$tKey] = true;
        $catId = (int) $art['category_id'];
        $slug = $art['slug'];
        $urlPath = match ($catId) {
            1 => "/workflow/{$slug}",
            5 => "/mcp-directory/{$slug}",
            default => "/blogs/{$slug}",
        };
        $art['url'] = "https://dailyaiworld.com" . $urlPath;
        $art['deck'] = !empty($art['deck']) ? $art['deck'] : (!empty($art['excerpt']) ? $art['excerpt'] : 'Read full technical implementation on Daily AI World.');
        $articles[] = $art;
    }
}

$articleCount = count($articles);
$formattedDate = date('F j, Y', strtotime($targetDate));

// High-Converting CTR Subject Line
$firstTitle = $articles[0]['title'] ?? 'AI Breakthroughs';
$subjectTitle = "⚡ Daily AI World: {$firstTitle} (" . date('M j', strtotime($targetDate)) . ")";

$data = [
    'appName'        => 'Daily AI World',
    'editionName'    => 'Executive Dark Briefing',
    'issueDate'      => $formattedDate,
    'subjectTitle'   => $subjectTitle,
    'siteUrl'        => 'https://dailyaiworld.com',
    'articles'       => $articles,
    'unsubscribeUrl' => 'https://dailyaiworld.com/unsubscribe',
];

echo "\n===================================================\n";
echo " 📬 DAILY AI WORLD — EXECUTIVE DARK NEWSLETTER\n";
echo "===================================================\n";
echo " Target Date:    {$targetDate} ({$formattedDate})\n";
echo " Subject Line:   {$subjectTitle}\n";
echo " Articles Found: {$articleCount} dispatches\n";
echo " Theme:          Executive Cyber-Minimal Dark (#08090D)\n";
echo " Mode:           " . ($isLive ? "LIVE PRODUCTION DISPATCH" : ($testEmail ? "TEST SEND TO {$testEmail}" : "DRY RUN / PREVIEW")) . "\n";
echo "===================================================\n\n";

foreach ($articles as $idx => $art) {
    $cat = match ((int)$art['category_id']) {
        1 => 'Workflow',
        5 => 'MCP Tool',
        3 => 'Coding',
        10 => 'LLMs',
        default => 'News'
    };
    echo " [" . ($idx + 1) . "] ({$cat}) {$art['title']}\n";
}
echo "\n";

// 3. Handle HTML Preview Generation
if ($htmlPreview) {
    $htmlContent = View::make('emails.dark-digest', $data)->render();
    $previewPath = __DIR__ . '/../public/preview-dark-newsletter.html';
    file_put_contents($previewPath, $htmlContent);
    echo "✅ HTML Preview written to: {$previewPath}\n";
    echo "   You can view it in your browser or run: open public/preview-dark-newsletter.html\n\n";
    if (!$isLive && !$testEmail) {
        exit(0);
    }
}

// 4. Resolve Target Recipients
if ($testEmail) {
    $subscribers = [
        ['id' => 0, 'email' => $testEmail, 'status' => 'active']
    ];
} else {
    $query = "SELECT id, email, status FROM newsletter_subscribers WHERE status = 'active' ORDER BY id ASC";
    if ($limit && $limit > 0) {
        $query .= " LIMIT {$limit}";
    }
    $subStmt = $pdo->query($query);
    $subscribers = $subStmt->fetchAll(PDO::FETCH_ASSOC);
}

$recipientCount = count($subscribers);
echo "Targeting {$recipientCount} recipient(s). Starting sequence...\n";
echo "---------------------------------------------------\n";

$sentCount = 0;
$failCount = 0;

foreach ($subscribers as $idx => $sub) {
    $num = str_pad($idx + 1, 3, ' ', STR_PAD_LEFT);
    $email = trim($sub['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "[{$num}/{$recipientCount}] ⚠️ Invalid email: {$email}\n";
        $failCount++;
        continue;
    }

    echo "[{$num}/{$recipientCount}] Sending to: {$email} ... ";

    if (!$isLive && !$testEmail) {
        echo "✅ [DRY RUN OK]\n";
        $sentCount++;
        continue;
    }

    try {
        Mail::send('emails.dark-digest', $data, function ($message) use ($email, $subjectTitle, $targetDate) {
            $message->to($email)
                    ->subject($subjectTitle);

            // Brevo Headers for Tracking & High Primary-Inbox Deliverability
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailin-Tag', "dark-digest-{$targetDate}");
            $headers->addTextHeader('X-Mailin-Custom', json_encode([
                'theme'   => 'dark-minimal',
                'edition' => 'Executive Dark Briefing',
                'date'    => $targetDate,
            ]));
        });

        echo "✅ SENT\n";
        $sentCount++;

        // 150ms throttle to comply with Brevo SMTP relay rate limits
        usleep(150000);
    } catch (\Throwable $e) {
        echo "❌ FAILED: " . $e->getMessage() . "\n";
        $failCount++;
    }
}

echo "\n===================================================\n";
echo " 📊 DISPATCH COMPLETE SUMMARY\n";
echo "===================================================\n";
echo " Total Target Recipients: {$recipientCount}\n";
echo " Successfully Sent:       {$sentCount}\n";
echo " Failed / Skipped:        {$failCount}\n";
echo " Delivery Success Rate:   " . ($recipientCount > 0 ? round(($sentCount / $recipientCount) * 100, 2) : 0) . "%\n";
echo " Template:                resources/views/emails/dark-digest.blade.php\n";
echo " Brevo Campaign Tag:      dark-digest-{$targetDate}\n";
echo "===================================================\n";
