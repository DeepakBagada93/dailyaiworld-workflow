<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Setup Hostinger connection
config([
    'database.connections.hostinger' => [
        'driver' => 'mysql',
        'host' => 'srv1334.hstgr.io',
        'port' => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'options' => [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_PERSISTENT => true,
        ],
    ]
]);

try {
    // Test connection
    $result = DB::connection('hostinger')->select('SELECT 1 as connected');
    echo "✅ Hostinger connection successful\n";
    
    // Check if articles table exists
    $tableExists = DB::connection('hostinger')->select("SHOW TABLES LIKE 'articles'");
    if (!empty($tableExists)) {
        echo "✅ Articles table exists\n";
        
        // Count existing articles
        $count = DB::connection('hostinger')->select('SELECT COUNT(*) as count FROM articles');
        echo "📊 Current articles count: " . $count[0]->count . "\n";
        
        // Get latest article
        $latest = DB::connection('hostinger')->select('SELECT id, title, slug FROM articles ORDER BY id DESC LIMIT 1');
        if (!empty($latest)) {
            echo "📝 Latest article: [" . $latest[0]->id . "] " . $latest[0]->title . "\n";
        }
    } else {
        echo "❌ Articles table not found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Hostinger connection failed: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getCode() . "\n";
}
