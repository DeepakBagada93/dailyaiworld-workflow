<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\SponsorReport;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class RevenueSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Top AI Sponsor Companies
        $sponsorsData = [
            [
                'name' => 'Anthropic',
                'website_url' => 'https://anthropic.com',
                'contact_email' => 'partnerships@anthropic.com',
                'status' => 'active',
                'notes' => 'Key Sponsor for Claude 3.7 Sonnet & Enterprise AI Dispatches.',
            ],
            [
                'name' => 'Pinecone',
                'website_url' => 'https://pinecone.io',
                'contact_email' => 'sponsorships@pinecone.io',
                'status' => 'active',
                'notes' => 'Sponsors Vector DB & RAG Architecture Desks.',
            ],
            [
                'name' => 'Fireworks AI',
                'website_url' => 'https://fireworks.ai',
                'contact_email' => 'growth@fireworks.ai',
                'status' => 'active',
                'notes' => 'Fastest open-weight inference provider sponsor.',
            ],
            [
                'name' => 'LangChain',
                'website_url' => 'https://langchain.com',
                'contact_email' => 'editor@langchain.dev',
                'status' => 'active',
                'notes' => 'Agentic AI Framework Partner.',
            ],
            [
                'name' => 'Scale AI',
                'website_url' => 'https://scale.com',
                'contact_email' => 'marketing@scale.com',
                'status' => 'prospect',
                'notes' => 'Lead inquiry for Q3 Partner Spotlight.',
            ],
        ];

        foreach ($sponsorsData as $data) {
            Sponsor::firstOrCreate(['name' => $data['name']], $data);
        }

        $anthropic = Sponsor::where('name', 'Anthropic')->first();
        $pinecone = Sponsor::where('name', 'Pinecone')->first();
        $fireworks = Sponsor::where('name', 'Fireworks AI')->first();
        $langchain = Sponsor::where('name', 'LangChain')->first();

        // 2. Sample Articles for Placements
        $articles = Article::take(5)->get();
        $article1 = $articles->first();
        $article2 = $articles->skip(1)->first();

        // Mark 1-2 articles as premium/sponsored tier
        if ($article1) {
            $article1->update(['tier' => 'Research Breakdown']);
        }
        if ($article2) {
            $article2->update(['tier' => 'Briefing']);
        }

        // 3. Active Sponsorships
        if ($anthropic) {
            Sponsorship::firstOrCreate([
                'sponsor_id' => $anthropic->id,
                'placement_type' => 'newsletter',
            ], [
                'article_id' => $article1?->id,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(15),
                'price_paid' => 4500.00,
                'impressions' => 42100,
                'clicks' => 3840,
                'status' => 'active',
                'custom_copy' => 'Build next-gen agentic workflows with Claude 3.7 Sonnet on Anthropic API.',
            ]);
        }

        if ($pinecone) {
            Sponsorship::firstOrCreate([
                'sponsor_id' => $pinecone->id,
                'placement_type' => 'category_rail',
            ], [
                'article_id' => $article2?->id,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'price_paid' => 2800.00,
                'impressions' => 28900,
                'clicks' => 1950,
                'status' => 'active',
                'custom_copy' => 'Pinecone Serverless: High-speed vector indexing for Enterprise RAG.',
            ]);
        }

        if ($fireworks) {
            Sponsorship::firstOrCreate([
                'sponsor_id' => $fireworks->id,
                'placement_type' => 'dispatch',
            ], [
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'price_paid' => 3200.00,
                'impressions' => 18400,
                'clicks' => 1420,
                'status' => 'active',
                'custom_copy' => 'Run Llama-3 70B at 140 tokens/sec with Fireworks AI.',
            ]);
        }

        // 4. Subscriptions (Executive Tier Members)
        $subscribers = [
            ['email' => 'alex.chen@openai.com', 'plan' => 'annual', 'amount' => 190.00, 'status' => 'active'],
            ['email' => 'sarah.jenkins@stripe.com', 'plan' => 'monthly', 'amount' => 19.00, 'status' => 'active'],
            ['email' => 'david.k@vercel.com', 'plan' => 'monthly', 'amount' => 19.00, 'status' => 'active'],
            ['email' => 'marcus.v@a16z.com', 'plan' => 'annual', 'amount' => 190.00, 'status' => 'active'],
            ['email' => 'priya.s@linear.app', 'plan' => 'monthly', 'amount' => 19.00, 'status' => 'active'],
            ['email' => 'tom.h@github.com', 'plan' => 'annual', 'amount' => 190.00, 'status' => 'active'],
        ];

        foreach ($subscribers as $sub) {
            Subscription::firstOrCreate(
                ['email' => $sub['email']],
                [
                    'plan' => $sub['plan'],
                    'amount' => $sub['amount'],
                    'status' => $sub['status'],
                    'stripe_subscription_id' => 'sub_live_' . strtoupper(substr(md5($sub['email']), 0, 10)),
                    'current_period_end' => now()->addDays(180),
                ]
            );
        }

        // 5. Affiliate Links
        if ($article1) {
            AffiliateLink::firstOrCreate(
                ['url' => 'https://anthropic.com/claude-api'],
                [
                    'article_id' => $article1->id,
                    'label' => 'Try Claude 3.7 API (Free $5 Credits)',
                    'disclosure_text' => 'Daily AI World reader exclusive partner offer.',
                    'click_count' => 1240,
                    'revenue_earned' => 860.00,
                ]
            );
        }

        if ($article2) {
            AffiliateLink::firstOrCreate(
                ['url' => 'https://pinecone.io/start'],
                [
                    'article_id' => $article2->id,
                    'label' => 'Deploy Pinecone Serverless Vector Store',
                    'disclosure_text' => 'Sponsored link — Daily AI World may earn a commission.',
                    'click_count' => 910,
                    'revenue_earned' => 640.00,
                ]
            );
        }

        // 6. Monthly Sponsor Performance Reports
        if ($anthropic) {
            SponsorReport::firstOrCreate(
                ['sponsor_id' => $anthropic->id, 'report_month' => now()->format('Y-m')],
                [
                    'total_impressions' => 42100,
                    'total_clicks' => 3840,
                    'ctr' => 9.12,
                    'total_spend' => 4500.00,
                    'summary_json' => [
                        'top_channel' => 'Executive Newsletter Briefing',
                        'audience_reach' => '100% Verified AI Developers & Founders',
                    ],
                ]
            );
        }
    }
}
