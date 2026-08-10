<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticlePublishingService
{
    /**
     * Publish an article payload to both Local MySQL and Live Hostinger Remote MySQL databases.
     *
     * @param array $data
     * @return array
     */
    public function publish(array $data): array
    {
        $slug = Article::generateSeoSlug($data['title']);
        $slug = Article::ensureUniqueSlug($slug);

        $takeawaysJson = isset($data['key_takeaways']) 
            ? (is_array($data['key_takeaways']) ? json_encode($data['key_takeaways']) : $data['key_takeaways'])
            : json_encode([]);

        $faqsJson = isset($data['faqs']) 
            ? (is_array($data['faqs']) ? json_encode($data['faqs']) : $data['faqs'])
            : json_encode([]);

        $publishedAt = isset($data['published_at']) ? \Carbon\Carbon::parse($data['published_at']) : now();
        $status = $data['status'] ?? ($publishedAt->isFuture() ? 'scheduled' : 'published');

        $featuredImage = $data['featured_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80';
        if (!empty($featuredImage) && !str_starts_with($featuredImage, 'http://') && !str_starts_with($featuredImage, 'https://')) {
            $featuredImage = url('/' . ltrim($featuredImage, '/'));
        }

        $row = [
            'category_id'    => (int) ($data['category_id'] ?? 1),
            'author_id'      => (int) ($data['author_id'] ?? 1),
            'title'          => $data['title'],
            'slug'           => $slug,
            'deck'           => $data['deck'] ?? '',
            'ai_summary'     => $data['ai_summary'] ?? ($data['deck'] ?? ''),
            'content'        => $data['content'],
            'excerpt'        => $data['excerpt'] ?? ($data['deck'] ?? ''),
            'featured_image' => $featuredImage,
            'reading_time'   => (int) ($data['reading_time'] ?? 8),
            'audio_url'      => $data['audio_url'] ?? null,
            'key_takeaways'  => $takeawaysJson,
            'faqs'           => $faqsJson,
            'tier'           => $data['tier'] ?? 'Deep Dive',
            'is_hero'        => (int) ($data['is_hero'] ?? 0),
            'is_featured'    => (int) ($data['is_featured'] ?? 0),
            'status'         => $status,
            'published_at'   => $publishedAt,
            'updated_date'   => now(),
            'view_count'     => 0,
            'trending_score' => (float) ($data['trending_score'] ?? 85.0),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        $results = [
            'slug' => $slug,
            'local_status' => false,
            'remote_status' => false,
            'local_id' => null,
            'live_url' => "https://dailyaiworld.com/blogs/{$slug}",
        ];

        // Adjust live URL path based on type if passed
        if (isset($data['type'])) {
            if ($data['type'] === 'workflow') {
                $results['live_url'] = "https://dailyaiworld.com/workflow/{$slug}";
            } elseif ($data['type'] === 'mcp') {
                $results['live_url'] = "https://dailyaiworld.com/mcp-directory/{$slug}";
            }
        }

        // 1. Insert into Local MySQL
        try {
            $localId = DB::table('articles')->insertGetId($row);
            $results['local_status'] = true;
            $results['local_id'] = $localId;
        } catch (\Throwable $e) {
            Log::error('Local DB Insert Error: ' . $e->getMessage());
            $results['local_error'] = $e->getMessage();
        }

        // 2. Insert into Remote Hostinger MySQL
        try {
            DB::connection('hostinger')->table('articles')->insert($row);
            $results['remote_status'] = true;
        } catch (\Throwable $e) {
            Log::error('Hostinger Remote DB Insert Error: ' . $e->getMessage());
            $results['remote_error'] = $e->getMessage();
        }

        return $results;
    }
}
