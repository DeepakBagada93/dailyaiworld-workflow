<?php
/**
 * Direct Standalone API Bridge for Public HTML / Hostinger Web Hosting Environments.
 * This standalone script operates directly within public_html without full framework boot dependency.
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type, Accept');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed. Use POST.']);
    exit;
}

// 1. Verify Secret Key / Bearer Token
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
$token = str_replace('Bearer ', '', $authHeader);

$SECRET_TOKEN = 'DailyAI_Publish_Secret_2026_Secure_Token_X98';

if (empty($token) || $token !== $SECRET_TOKEN) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Invalid API Secret Token.']);
    exit;
}

// 2. Parse Input Data
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || empty($data['title']) || empty($data['content'])) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Validation error: Title and content are required.']);
    exit;
}

// 3. Connect to Database (Live Hostinger MySQL)
$host = '193.203.184.64';
$db   = 'u775719140_dailyai';
$user = 'u775719140_admin';
$pass = 'Dailyaiworld@3093';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Helper slug generator
function generateSlug($title) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    return rtrim($slug, '-');
}

$slug = generateSlug($data['title']);

// Check unique slug
$stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE slug = ?");
$stmt->execute([$slug]);
if ($stmt->fetchColumn() > 0) {
    $slug .= '-' . time();
}

$takeawaysJson = isset($data['key_takeaways']) ? json_encode($data['key_takeaways']) : json_encode([]);
$faqsJson      = isset($data['faqs']) ? json_encode($data['faqs']) : json_encode([]);
$type          = $data['type'] ?? 'blog';

$row = [
    'category_id'    => (int) ($data['category_id'] ?? 1),
    'author_id'      => (int) ($data['author_id'] ?? 1),
    'title'          => $data['title'],
    'slug'           => $slug,
    'deck'           => $data['deck'] ?? '',
    'ai_summary'     => $data['ai_summary'] ?? ($data['deck'] ?? ''),
    'content'        => $data['content'],
    'excerpt'        => $data['excerpt'] ?? ($data['deck'] ?? ''),
    'featured_image' => $data['featured_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
    'reading_time'   => (int) ($data['reading_time'] ?? 8),
    'audio_url'      => null,
    'key_takeaways'  => $takeawaysJson,
    'faqs'           => $faqsJson,
    'tier'           => $data['tier'] ?? 'Deep Dive',
    'is_hero'        => 0,
    'is_featured'    => 0,
    'status'         => 'published',
    'published_at'   => date('Y-m-d H:i:s'),
    'updated_date'   => date('Y-m-d H:i:s'),
    'view_count'     => 0,
    'trending_score' => 85.0,
    'created_at'     => date('Y-m-d H:i:s'),
    'updated_at'     => date('Y-m-d H:i:s'),
];

$sql = "INSERT INTO articles (" . implode(', ', array_keys($row)) . ") VALUES (" . implode(', ', array_fill(0, count($row), '?')) . ")";

try {
    $insertStmt = $pdo->prepare($sql);
    $insertStmt->execute(array_values($row));
    $articleId = $pdo->lastInsertId();

    $liveUrl = "https://dailyaiworld.tech/blogs/{$slug}";
    if ($type === 'workflow') {
        $liveUrl = "https://dailyaiworld.tech/workflow/{$slug}";
    } elseif ($type === 'mcp') {
        $liveUrl = "https://dailyaiworld.tech/mcp-directory/{$slug}";
    }

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Article published directly to live hostinger public_html website!',
        'data' => [
            'id' => $articleId,
            'slug' => $slug,
            'live_url' => $liveUrl
        ]
    ]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $e->getMessage()]);
}
