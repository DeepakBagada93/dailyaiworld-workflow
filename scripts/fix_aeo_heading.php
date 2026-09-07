<?php
/**
 * Daily AI World — Fix AEO Direct Answer Box Heading in Content
 * 
 * The `## AEO Direct Answer Box` markdown heading renders as a visible <h2>
 * in the article body AND appears in the Table of Contents, which is not desired.
 * The AEO answer content should appear as direct body paragraphs without a heading.
 * 
 * This script strips all instances of `## AEO Direct Answer Box` heading patterns
 * from article content in both Hostinger and local databases, keeping the
 * content paragraphs beneath them intact.
 *
 * Usage: php scripts/fix_aeo_heading.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Setup Hostinger connection
config([
    'database.connections.hostinger' => [
        'driver'   => 'mysql',
        'host'     => 'srv1334.hstgr.io',
        'port'     => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset'  => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'   => '',
        'strict'   => false,
        'options'  => [\PDO::ATTR_TIMEOUT => 30],
    ]
]);

function fixAeoHeading(string $content): string {
    // Pattern 1: "## AEO Direct Answer Box\n\n" followed by content — strip heading, keep content
    // Pattern 2: "## AEO Direct Answer Box\n" without extra newline
    $patterns = [
        '/^##\s+AEO\s+Direct\s+Answer\s+Box\s*\n+/im' => '',
        '/\n##\s+AEO\s+Direct\s+Answer\s+Box\s*\n+/im' => "\n",
        '/^##\s+AEO\s+Direct\s+Answer\s+Box\s*$/im' => '',  // At end with no trailing newline
    ];
    
    $fixed = $content;
    foreach ($patterns as $pattern => $replacement) {
        $fixed = preg_replace($pattern, $replacement, $fixed);
    }
    
    // Also clean up double newlines that might result from removal
    $fixed = preg_replace('/\n{3,}/', "\n\n", $fixed);
    
    return $fixed;
}

$databases = [
    'hostinger' => 'Hostinger Remote MySQL (srv1334.hstgr.io)',
    'local'     => 'Local MySQL',
];

$totalFixed = 0;

foreach ($databases as $connection => $label) {
    try {
        // Get all articles with the AEO heading pattern
        $articles = DB::connection($connection)
            ->table('articles')
            ->select(['id', 'title', 'slug', 'content'])
            ->where('content', 'LIKE', '%AEO Direct Answer Box%')
            ->orWhere('content', 'LIKE', '%## AEO Direct%')
            ->orderBy('id')
            ->get();
        
        $connCount = count($articles);
        echo "\n📦 {$label}: Found {$connCount} articles with AEO heading\n";
        
        $fixed = 0;
        $skipped = 0;
        
        foreach ($articles as $article) {
            $original = $article->content;
            $fixedContent = fixAeoHeading($original);
            
            if ($fixedContent !== $original) {
                DB::connection($connection)
                    ->table('articles')
                    ->where('id', $article->id)
                    ->update(['content' => $fixedContent]);
                $fixed++;
                echo "  ✅ Fixed [{$article->id}] {$article->title}\n";
            } else {
                $skipped++;
                echo "  ⏭️ Skipped [{$article->id}] Already clean\n";
            }
        }
        
        echo "  📊 {$label}: {$fixed} fixed, {$skipped} skipped (of {$connCount} checked)\n";
        $totalFixed += $fixed;
        
    } catch (\Throwable $e) {
        echo "  ❌ Error on {$label}: " . $e->getMessage() . "\n";
    }
}

echo "\n🏁 Total articles fixed across all databases: {$totalFixed}\n";
echo "✅ AEO heading cleanup complete!\n";