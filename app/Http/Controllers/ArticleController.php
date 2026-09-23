<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, string $categorySlug, string $slug)
    {
        // Resolve the published article by slug first.
        // If not found, attempt fuzzy resolution (e.g. stripped timestamps or prefix matches)
        $article = Article::with(['category', 'author', 'comments', 'sponsorships.sponsor', 'affiliateLinks'])
            ->where('slug', $slug)
            ->published()
            ->first();

        if (!$article) {
            // 1. Explicit Redirect Map for deduplicated & renamed content
            $redirectMap = [
                'trending-blog-codex-6' => 'nvidia-nemotron-3-ultra-agent-orchestration-2026',
                'deepseek-v4-flash-0731-vs-claude-opus-vs-gpt-56-sol-2' => 'deepseek-v4-flash-0731-vs-claude-opus-vs-gpt-56-sol',
                'context-window-vs-context-recall-1m-token-windows-fail' => 'context-length-vs-context-recall-1m-token-context-windows',
                'amd-bets-5b-anthropic-nvidia-backs-ssi-frontier-chip' => 'amd-bets-5b-anthropic-nvidia-backs-ssi-frontier-chip-race',
                'anthropics-invisible-c2pa-watermarks-claude-outputs-prove-3' => 'anthropics-invisible-c2pa-watermarks-claude-outputs-prove',
                'anthropics-invisible-c2pa-watermarks-claude-outputs-prove-2' => 'anthropics-invisible-c2pa-watermarks-claude-outputs-prove',
                'anthropics-multi-agent-turf-war-study-ai-agents-sabotage' => 'anthropics-multi-agent-turf-war-study-claude-agents',
                'cursor-2026-agent-mode-google-workspace-plugins-multi-file' => 'cursor-agent-mode-2026-google-workspace-plugins-multi-file',
                'openai-assistants-api-sunset-tomorrow-migration-responses' => 'openai-sets-august-26-assistants-api-sunset-migration',
                'okta-launches-agent-sso-ai-agents-now-log-like-employees' => 'okta-launches-agent-sso-ai-agents-login-like-employees',
                'ship-agent-token-budget-enforcer-prevented-47k-runaway-cost' => 'build-autonomous-agent-token-budget-enforcer-prevented-47k',
                'swe-bench-verified-96-benchmark-saturation-crisis-2026' => 'swe-bench-verified-hits-96-benchmark-saturation-crisis-2026',
                'snowflake-data-warehouse-analytics-query-optimizer-fastmcp-2' => 'dominate-100m-rows-build-snowflake-mcp-server-real-time',
                'eu-ai-act-2026-compliance-audit-autonomous-ai-agents-3' => 'eu-ai-act-2026-compliance-audit-autonomous-ai-agents',
                'build-auto-scaling-rag-pipeline-pinecone-serverless-load-2' => 'build-auto-scaling-rag-pipeline-pinecone-serverless-load',
                'claude-code-n8n-build-workflows-10-min-2026-guide' => 'how-to-n8n-mcp-server-claude-code-builder-2026',
                'n8n-claude-code-workflows-from-4-hours-to-8-minutes' => 'how-to-n8n-mcp-server-claude-code-builder-2026',
                'how-to-build-n8n-workflows-with-claude-code-6-steps' => 'how-to-n8n-mcp-server-claude-code-builder-2026',
            ];

            if (isset($redirectMap[$slug])) {
                $mappedArticle = Article::where('slug', $redirectMap[$slug])->published()->first();
                if ($mappedArticle) {
                    return redirect($mappedArticle->url, 301);
                }
            }

            // 2. Check if slug has numeric duplicate suffix like -2, -3, etc.
            $baseDuplicateSlug = preg_replace('/-[0-9]+$/', '', $slug);
            if ($baseDuplicateSlug !== $slug) {
                $canonicalArticle = Article::where('slug', $baseDuplicateSlug)->published()->first();
                if ($canonicalArticle) {
                    return redirect($canonicalArticle->url, 301);
                }
            }

            // 3. Timestamped suffixes and forward prefix match
            $baseSlug = preg_replace('/-[0-9]{10,}$/', '', $slug);
            $cleanSlug = rtrim($baseSlug, '*&$');
            
            $article = Article::with(['category', 'author', 'comments', 'sponsorships.sponsor', 'affiliateLinks'])
                ->where('slug', 'like', $cleanSlug . '%')
                ->published()
                ->first();

            if ($article) {
                return redirect($article->url, 301);
            }

            // 4. Reverse prefix match: existing article whose slug is a prefix of requested slug
            $reversePrefixArt = Article::whereRaw('? LIKE CONCAT(slug, "%")', [$cleanSlug])
                ->published()
                ->first();

            if ($reversePrefixArt) {
                return redirect($reversePrefixArt->url, 301);
            }

            // If truly not found, redirect to the relevant hub or homepage with a 301
            // instead of returning a hard 404, recovering SEO link equity for Googlebot.
            if ($categorySlug === 'workflow' || $categorySlug === 'workflows') {
                return redirect('/workflows', 301);
            } elseif ($categorySlug === 'mcp-directory' || $categorySlug === 'mcp') {
                return redirect('/mcp-directory', 301);
            } elseif ($categorySlug === 'blogs' || $categorySlug === 'blog') {
                return redirect('/latest-ai-news', 301);
            }

            return redirect('/', 301);
        }

        // Canonical prefix per category — must mirror Article::getUrlAttribute()
        if ($article->category_id == 1) {
            $canonicalPrefix = 'workflow';
        } elseif ($article->category_id == 5) {
            $canonicalPrefix = 'mcp-directory';
        } else {
            $canonicalPrefix = 'blogs';
        }

        // Enforce strict category prefix: legacy /mcp/ or mismatched prefixes 301-redirect to canonical URL
        // (prevents duplicate self-canonicalizing /mcp/{slug} vs /mcp-directory/{slug})
        if ($categorySlug !== $canonicalPrefix) {
            return redirect($article->url, 301);
        }

        // Protect DB write performance during Googlebot crawl bursts: only count human visitors
        $userAgent = strtolower($request->header('User-Agent', ''));
        $isCrawler = preg_match('/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|google|bing|yandex|duckduckgo|baidu/i', $userAgent);
        if (!$isCrawler) {
            $article->increment('view_count');
        }

        // Check if user has active subscription
        $isSubscribed = auth()->check() ? auth()->user()->isSubscribed() : false;

        // Previous and Next Article Navigation
        $prevArticle = Article::published()
            ->where('published_at', '<', $article->published_at)
            ->latest('published_at')
            ->first();

        $nextArticle = Article::published()
            ->where('published_at', '>', $article->published_at)
            ->oldest('published_at')
            ->first();

        $relatedArticles = Article::with(['category', 'author'])
            ->published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $extra = Article::with(['category', 'author'])
                ->published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->merge($extra);
        }

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = Bookmark::where('user_id', auth()->id())
                ->where('article_id', $article->id)
                ->exists();
        } else {
            $bookmarkedIds = session()->get('bookmarks', []);
            $isBookmarked = in_array($article->id, $bookmarkedIds);
        }

        return response()
            ->view('articles.show', compact(
                'article',
                'relatedArticles',
                'prevArticle',
                'nextArticle',
                'isBookmarked',
                'isSubscribed'
            ))
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=86400');
    }

    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'content' => 'required|string|max:2000',
        ]);

        $comment = Comment::create([
            'article_id' => $article->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'is_approved' => true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'name' => $comment->name,
                    'content' => $comment->content,
                    'date' => $comment->formatted_date,
                ],
            ]);
        }

        return back()->with('success', 'Your commentary has been published to the thread.');
    }
}
