<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\MarketIndex;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EditorialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full administrative control over publication'],
            ['name' => 'Editor', 'slug' => 'editor', 'description' => 'Can edit, review, and publish all editorial dispatches'],
            ['name' => 'Author', 'slug' => 'author', 'description' => 'Can write and submit draft articles'],
            ['name' => 'Subscriber', 'slug' => 'subscriber', 'description' => 'Registered reader with saved library access'],
        ];

        foreach ($roles as $r) {
            DB::table('roles')->updateOrInsert(['slug' => $r['slug']], $r);
        }

        // 2. Main Admin User: Deepak Bagada
        $deepakUser = User::firstOrCreate(
            ['email' => 'deepak@saasnext.com'],
            [
                'name' => 'Deepak Bagada',
                'role' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        if ($adminRole) {
            DB::table('role_user')->updateOrInsert(
                ['role_id' => $adminRole->id, 'user_id' => $deepakUser->id]
            );
        }

        // 3. Primary Global Author: Deepak Bagada (CEO, SaaSNext)
        $deepakAuthor = Author::updateOrCreate(
            ['slug' => 'deepak-bagada'],
            [
                'user_id' => $deepakUser->id,
                'name' => 'Deepak Bagada',
                'slug' => 'deepak-bagada',
                'title' => 'CEO, SaaSNext',
                'avatar' => '/images/deepak-bagada.png',
                'bio' => 'Deepak Bagada is the CEO of SaaSNext and founder of Daily AI World. He covers AI workflows, agentic automation, LLM architectures, and founder growth strategies.',
                'twitter' => '@deepakbagada',
                'linkedin' => 'https://linkedin.com/in/deepakbagada',
            ]
        );

        // Also create entry in authors_prod
        DB::table('authors_prod')->updateOrInsert(
            ['slug' => 'deepak-bagada'],
            [
                'user_id' => $deepakUser->id,
                'name' => 'Deepak Bagada',
                'slug' => 'deepak-bagada',
                'title' => 'CEO, SaaSNext',
                'avatar' => '/images/deepak-bagada.png',
                'bio' => 'Deepak Bagada is the CEO of SaaSNext and founder of Daily AI World.',
                'twitter' => '@deepakbagada',
                'linkedin' => 'https://linkedin.com/in/deepakbagada',
            ]
        );

        // 4. Fixed Global Categories
        $categories = [
            ['name' => 'AI Workflows', 'slug' => 'ai-workflows', 'description' => 'Step-by-step production AI workflow architectures, event loops, and agent orchestration for builders.', 'accent_color' => '#6D28D9', 'icon' => 'arrow-path', 'is_featured' => true],
            ['name' => 'Agentic AI', 'slug' => 'agentic-ai', 'description' => 'Autonomous agent swarms, tool execution, long-horizon planning, and state management.', 'accent_color' => '#2563EB', 'icon' => 'bot', 'is_featured' => true],
            ['name' => 'Coding', 'slug' => 'coding', 'description' => 'Frontier LLM code generation, AST parsers, compiler feedback loops, and developer tooling.', 'accent_color' => '#7C3AED', 'icon' => 'code-bracket', 'is_featured' => true],
            ['name' => 'Automation', 'slug' => 'automation', 'description' => 'Headless background workers, workflow triggers, and enterprise process automation.', 'accent_color' => '#059669', 'icon' => 'bolt', 'is_featured' => true],
            ['name' => 'AI Tools', 'slug' => 'ai-tools', 'description' => 'Evaluations and benchmarks of AI developer tools, IDE extensions, and vector databases.', 'accent_color' => '#D97706', 'icon' => 'wrench-screwdriver', 'is_featured' => true],
            ['name' => 'Open Source', 'slug' => 'open-source', 'description' => 'Quantization techniques, GGUF/EXL2 weights, local deployment, and permissive AI licensing.', 'accent_color' => '#DC2626', 'icon' => 'folder-open', 'is_featured' => true],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'ARR per employee benchmarks, venture capital models, and AI business unit economics.', 'accent_color' => '#4B5563', 'icon' => 'chart-bar', 'is_featured' => false],
            ['name' => 'Startups', 'slug' => 'startups', 'description' => 'Hyper-lean AI startup playbooks, go-to-market strategies, and founder growth.', 'accent_color' => '#6D28D9', 'icon' => 'rocket', 'is_featured' => false],
            ['name' => 'Productivity', 'slug' => 'productivity', 'description' => 'Maximizing developer velocity and executive leverage using state-of-the-art AI stacks.', 'accent_color' => '#2563EB', 'icon' => 'sparkles', 'is_featured' => false],
            ['name' => 'LLMs', 'slug' => 'llms', 'description' => 'Frontier model releases, mixture-of-experts, reasoning tokens, and context window dynamics.', 'accent_color' => '#7C3AED', 'icon' => 'cpu', 'is_featured' => false],
            ['name' => 'AI News', 'slug' => 'ai-news', 'description' => 'Daily executive intelligence dispatches on compute markets and silicon supply chains.', 'accent_color' => '#059669', 'icon' => 'newspaper', 'is_featured' => false],
            ['name' => 'Tutorials', 'slug' => 'tutorials', 'description' => 'Hands-on technical guides for building production AI applications with Laravel and Python.', 'accent_color' => '#D97706', 'icon' => 'book-open', 'is_featured' => false],
        ];

        foreach ($categories as $catData) {
            Category::updateOrCreate(['slug' => $catData['slug']], $catData);
        }

        // 5. Market Ticker
        $marketIndices = [
            ['symbol' => 'LLM-MMLU', 'name' => 'Frontier MMLU-Pro Avg', 'value' => '92.4%', 'change_pct' => '+1.8%', 'direction' => 'up', 'type' => 'benchmark'],
            ['symbol' => 'H100-SPOT', 'name' => 'H100 SXM Spot Rate', 'value' => '$2.35/hr', 'change_pct' => '-4.2%', 'direction' => 'down', 'type' => 'gpu'],
            ['symbol' => 'AI-INDEX', 'name' => 'AI Top 50 Enterprise Index', 'value' => '3,482.10', 'change_pct' => '+2.4%', 'direction' => 'up', 'type' => 'index'],
            ['symbol' => 'B200-AVAIL', 'name' => 'Blackwell Cloud Availability', 'value' => '98.2%', 'change_pct' => '+0.5%', 'direction' => 'up', 'type' => 'gpu'],
            ['symbol' => 'SENTIMENT', 'name' => 'Founder Confidence Rating', 'value' => '88.4', 'change_pct' => '+3.1%', 'direction' => 'up', 'type' => 'sentiment'],
        ];

        foreach ($marketIndices as $idx) {
            MarketIndex::updateOrCreate(['symbol' => $idx['symbol']], $idx);
        }
    }
}
