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
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
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
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
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

        $workflowsCat = Category::where('slug', 'ai-workflows')->first();
        $agenticCat = Category::where('slug', 'agentic-ai')->first();
        $codingCat = Category::where('slug', 'coding')->first();
        $businessCat = Category::where('slug', 'business')->first();

        // 5. Seeded Editorial Articles (All authored by Deepak Bagada · CEO, SaaSNext)
        $articles = [
            [
                'title' => 'The Production Agentic Workflow Stack: How We Build Autonomous AI Pipelines at SaaSNext',
                'slug' => 'production-agentic-workflow-stack-saasnext',
                'deck' => 'An inside breakdown of event-driven agent swarms, state persistence, deterministic fallback loops, and reasoning token budget caps built for enterprise SaaS deployment.',
                'ai_summary' => 'In this deep dive, Deepak Bagada (CEO, SaaSNext) outlines the production architecture for agentic AI workflows. The article covers stateful memory persistence, circuit-breaker token budgets, and compiler verification loops.',
                'category_id' => $workflowsCat->id,
                'author_id' => $deepakAuthor->id,
                'tier' => 'Deep Dive',
                'is_hero' => true,
                'is_featured' => true,
                'reading_time' => 9,
                'featured_image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
                'audio_url' => 'https://actions.google.com/sounds/v1/ambiences/humming_fan.ogg',
                'key_takeaways' => [
                    'Stateful workflow recovery prevents lost execution states during API timeouts.',
                    'Deterministic AST verifiers catch 95% of hallucinated code prior to runtime.',
                    'Token budget circuit breakers cap maximum search tokens per enterprise request.'
                ],
                'faqs' => [
                    [
                        'question' => 'Why are traditional chat assistants insufficient for enterprise workflows?',
                        'answer' => 'Traditional single-turn chat assistants require continuous manual human intervention. Stateful agent swarms operate asynchronously against APIs and databases to complete end-to-end multi-step tasks.'
                    ]
                ],
                'excerpt' => 'Deploying raw foundation model outputs straight to production is a recipe for instability. At SaaSNext, we wrap probabilistic models in deterministic compiler feedback loops.',
                'content' => <<<MARKDOWN
## The Paradigm Shift from Chatbots to Autonomous Workflows

For the past three years, the tech ecosystem focused heavily on single-turn chat interfaces. But for builders and SaaS founders, conversational UI was only a temporary stepping stone. 

The real value of artificial intelligence lies in **headless, event-driven agentic workflows** that run continuously in the background.

```python
# Production Agentic Execution Pipeline at SaaSNext
class WorkflowOrchestrator:
    def __init__(self, agent_swarm, state_store):
        self.swarm = agent_swarm
        self.state_store = state_store

    def dispatch_task(self, payload):
        state = self.state_store.initialize(payload.id)
        while not state.is_complete():
            action = self.swarm.next_action(state.current_context())
            result = self.execute_guarded_tool(action)
            state.update(result)
        return state.final_output()
```

## Key Architectural Pillars at SaaSNext

1. **State Persistence**: Workflows survive process restarts with event-sourced transaction logs.
2. **Deterministic Guardrails**: Financial and legal boundaries enforced by schema validators.
3. **Outcome Metrics**: Software pricing evolves from seat licenses to verified work output.

> "Our focus at SaaSNext is building software that executes work, not just software that displays data." — *Deepak Bagada, CEO SaaSNext*
MARKDOWN
            ],
            [
                'title' => 'Deterministic Fallback Loops in AI Code Generation',
                'slug' => 'deterministic-fallback-loops-ai-code-generation',
                'deck' => 'How top engineering teams combine LLM code generation with AST parsers, static type-checkers, and automated test runners.',
                'ai_summary' => 'Deepak Bagada details engineering patterns for wrapping code generation models in compiler feedback loops.',
                'category_id' => $codingCat->id,
                'author_id' => $deepakAuthor->id,
                'tier' => 'Deep Dive',
                'reading_time' => 8,
                'featured_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'key_takeaways' => [
                    'AST verification catches syntax errors before execution.',
                    'Self-correcting compiler loops reduce manual PR review overhead.'
                ],
                'excerpt' => 'Deploying raw LLM code outputs straight to production is a recipe for disaster.',
                'content' => 'Technical analysis of compiler loop integration...',
            ],
            [
                'title' => 'SaaS 3.0 Valuation Frameworks: Why ARR per Employee Has Jumped 5x',
                'slug' => 'saas-3-valuation-frameworks-arr-per-employee',
                'deck' => 'An analysis of Series A and Series B AI companies reveals how hyper-lean teams scale past $10M ARR.',
                'ai_summary' => 'Deepak Bagada analyzes AI-native software company valuation models.',
                'category_id' => $businessCat->id,
                'author_id' => $deepakAuthor->id,
                'tier' => 'Founder Story',
                'reading_time' => 7,
                'featured_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
                'key_takeaways' => [
                    'Average team size for $10M ARR AI startups is under 15 employees.',
                    'Marginal cost of customer onboarding approaches zero with AI agents.'
                ],
                'excerpt' => 'Traditional software metrics dictated hiring 100 people for every $10M in ARR.',
                'content' => 'Venture valuation models for AI-native software companies...',
            ],
        ];

        foreach ($articles as $index => $articleData) {
            Article::updateOrCreate(
                ['slug' => $articleData['slug']],
                array_merge($articleData, [
                    'status' => 'published',
                    'published_at' => now()->subDays($index * 2),
                    'updated_date' => now()->subHours($index * 4 + 1),
                    'view_count' => rand(4500, 38000),
                    'trending_score' => 99.9 - ($index * 3.0),
                ])
            );
        }

        // 6. Market Ticker
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
