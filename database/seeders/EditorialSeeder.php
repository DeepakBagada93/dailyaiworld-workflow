<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\MarketIndex;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EditorialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Default Roles
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full administrative control over publication'],
            ['name' => 'Editor', 'slug' => 'editor', 'description' => 'Can edit, review, and publish all editorial dispatches'],
            ['name' => 'Author', 'slug' => 'author', 'description' => 'Can write and submit draft articles'],
            ['name' => 'Subscriber', 'slug' => 'subscriber', 'description' => 'Registered reader with saved library access'],
            ['name' => 'Guest', 'slug' => 'guest', 'description' => 'Anonymous reader'],
        ];

        foreach ($roles as $r) {
            DB::table('roles')->updateOrInsert(['slug' => $r['slug']], $r);
        }

        // 2. Default Permissions
        $permissions = [
            ['name' => 'Manage System', 'slug' => 'manage-system', 'description' => 'Full system access'],
            ['name' => 'Publish Posts', 'slug' => 'publish-posts', 'description' => 'Publish articles to production'],
            ['name' => 'Edit Posts', 'slug' => 'edit-posts', 'description' => 'Edit article content'],
            ['name' => 'Access CMS', 'slug' => 'access-cms', 'description' => 'Access enterprise CMS dashboard'],
        ];

        foreach ($permissions as $p) {
            DB::table('permissions')->updateOrInsert(['slug' => $p['slug']], $p);
        }

        // 3. Admin User
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@dailyaiworld.com'],
            [
                'name' => 'Chief Editor & Admin',
                'role' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        if ($adminRole) {
            DB::table('role_user')->updateOrInsert(
                ['role_id' => $adminRole->id, 'user_id' => $adminUser->id]
            );
        }

        // 4. Categories & Desks
        $categories = [
            [
                'name' => 'Coding',
                'slug' => 'coding-architectures',
                'description' => 'Dispatches on frontier language models, code generation, reasoning tokens, and compiler optimization.',
                'accent_color' => '#6D28D9',
                'icon' => 'code-bracket',
                'is_featured' => true,
            ],
            [
                'name' => 'AI Tools',
                'slug' => 'ai-tools',
                'description' => 'Autonomous developer tools, stateful agent swarms, and IDE integration breakdowns.',
                'accent_color' => '#2563EB',
                'icon' => 'wrench-screwdriver',
                'is_featured' => true,
            ],
            [
                'name' => 'Business',
                'slug' => 'business-saas',
                'description' => 'Venture economics, ARR per employee metrics, enterprise deployment ROI, and silicon capital allocation.',
                'accent_color' => '#059669',
                'icon' => 'chart-bar',
                'is_featured' => true,
            ],
            [
                'name' => 'Research',
                'slug' => 'research-papers',
                'description' => 'Peer-reviewed breakdowns of breakthrough papers from DeepMind, FAIR, Stanford, and independent research labs.',
                'accent_color' => '#DC2626',
                'icon' => 'academic-cap',
                'is_featured' => true,
            ],
            [
                'name' => 'Open Source',
                'slug' => 'open-source',
                'description' => 'Mixture of Experts, local quantized weights, open benchmark evaluations, and permissive licenses.',
                'accent_color' => '#D97706',
                'icon' => 'folder-open',
                'is_featured' => true,
            ],
        ];

        foreach ($categories as $catData) {
            Category::updateOrCreate(['slug' => $catData['slug']], $catData);
        }

        // 5. Tags
        $tags = ['Transformers', 'Reasoning Tokens', 'MoE', 'H100', 'B200', 'Quantization', 'Agents', 'SaaS ARR'];
        foreach ($tags as $t) {
            DB::table('tags')->updateOrInsert(['slug' => Str::slug($t)], ['name' => $t, 'slug' => Str::slug($t)]);
        }

        // 6. Authors
        $authorsData = [
            [
                'name' => 'Dr. Elena Vance',
                'slug' => 'dr-elena-vance',
                'title' => 'Chief AI Scholar & Former FAIR Fellow',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Elena covers frontier model architectures, training scaling laws, and reasoning search trees.',
                'twitter' => '@elenavance_ai',
                'linkedin' => 'elena-vance-ai',
            ],
            [
                'name' => 'Marcus Sterling',
                'slug' => 'marcus-sterling',
                'title' => 'Senior Compute & Silicon Analyst',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'bio' => 'Marcus focuses on GPU cluster economics, custom ASIC hardware, and data center megawatt bottlenecks.',
                'twitter' => '@msterling_tech',
                'linkedin' => 'marcus-sterling-compute',
            ],
        ];

        foreach ($authorsData as $auth) {
            Author::updateOrCreate(['slug' => $auth['slug']], array_merge($auth, ['user_id' => $adminUser->id]));
        }

        $codingCat = Category::where('slug', 'coding-architectures')->first();
        $elena = Author::where('slug', 'dr-elena-vance')->first();

        // 7. Hero Article
        $heroArticleData = [
            'title' => 'The Architecture Beyond Transformers: How Test-Time Compute is Reshaping AI Economics',
            'slug' => 'architecture-beyond-transformers-test-time-compute',
            'deck' => 'As brute-force pre-training scaling laws encounter physical power limits, frontier labs are pivoting to test-time reasoning search—fundamentally altering how enterprise software is architected and priced.',
            'ai_summary' => 'This comprehensive report explores the industry shift from static pre-training weight scaling to dynamic inference-time reasoning (test-time search). By trading off extra compute at execution time, models achieve expert human accuracy at a fraction of raw parameter size, redefining cloud unit economics and enterprise software architecture.',
            'category_id' => $codingCat->id,
            'author_id' => $elena->id,
            'tier' => 'Deep Dive',
            'is_hero' => true,
            'is_featured' => true,
            'reading_time' => 9,
            'featured_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
            'audio_url' => 'https://actions.google.com/sounds/v1/ambiences/humming_fan.ogg',
            'key_takeaways' => [
                'Pre-training scaling cost is shifting toward inference-time Search & Planning tokens.',
                'Reasoning models allow 100x lower parameters while achieving human-expert accuracy on benchmarks.',
                'Enterprise infrastructure must now optimize for low latency KV-cache reuse rather than raw prompt ingestion throughput.'
            ],
            'faqs' => [
                [
                    'question' => 'What is test-time compute scaling?',
                    'answer' => 'Test-time compute scaling refers to allowing a foundation model to execute search algorithms, verification loops, and self-correction steps during inference before returning a final response to the user.'
                ]
            ],
            'excerpt' => 'For five years, the scaling hypothesis reigned supreme: double the data, quadruple the parameters, and intelligence scales monotonically. But behind closed doors, the focus has drastically shifted to test-time search.',
            'content' => <<<MARKDOWN
## The Scaling Hypothesis Encounters Physical Limits

For five years, the scaling hypothesis reigned supreme across machine learning labs worldwide: double the tokens, quadruple the parameter count, and general capability will follow monotonically. Yet, as the industry encounters power constraints and electrical grid bottlenecks, a new consensus has emerged.

**Intelligence is no longer strictly bound to static weight parameters; it is dynamically generated during inference.**

```python
# Conceptual Test-Time Reasoning & Verification Loop
class ReasoningEngine:
    def __init__(self, generator_model, verifier_model):
        self.generator = generator_model
        self.verifier = verifier_model

    def execute_thought_tree(self, context, query, max_depth=5):
        candidates = self.generator.sample_hypotheses(context, query, k=8)
        best_candidate = None
        highest_score = 0.0

        for candidate in candidates:
            score = self.verifier.evaluate(context, candidate)
            if score > 0.95:
                return candidate  # Instant high-confidence exit
            if score > highest_score:
                highest_score = score
                best_candidate = candidate

        return self.branch_search(best_candidate, depth=max_depth)
```

## The Paradigm Shift in Capital Allocation

Venture capital firms and cloud providers are reorganizing their capital allocation strategies:

1. **KV-Cache Memory Bandwidth**: High HBM3e memory bandwidth is now prioritized over raw compute TFLOPs.
2. **Verification vs. Generation**: Verifier models are 10x smaller than generator models, running at hyper-fast speeds.
3. **Unit Economics**: Enterprise contracts are shifting from "pay per million input tokens" to "pay per verified solution."

> "We are witnessing the transition from static knowledge lookup to active mental simulation inside the model runtime." — *Dr. Elena Vance*
MARKDOWN
        ];

        Article::updateOrCreate(
            ['slug' => $heroArticleData['slug']],
            array_merge($heroArticleData, [
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'updated_date' => now()->subHours(4),
                'view_count' => 34200,
                'trending_score' => 99.9,
            ])
        );

        // 8. Market Ticker
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

        // 9. Navigation Settings & Menus
        DB::table('settings')->updateOrInsert(
            ['key' => 'site_title'],
            ['key' => 'site_title', 'value' => 'Daily AI World', 'type' => 'string']
        );

        DB::table('menus')->updateOrInsert(
            ['location' => 'header'],
            [
                'name' => 'Primary Navigation',
                'location' => 'header',
                'items_json' => json_encode([
                    ['title' => 'Coding', 'url' => '/category/coding-architectures'],
                    ['title' => 'AI Tools', 'url' => '/category/ai-tools'],
                    ['title' => 'Business', 'url' => '/category/business-saas'],
                    ['title' => 'Research', 'url' => '/category/research-papers'],
                    ['title' => 'Open Source', 'url' => '/category/open-source'],
                ]),
            ]
        );
    }
}
