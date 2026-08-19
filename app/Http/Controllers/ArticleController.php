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
        // Resolve the published article by slug first, then enforce the canonical
        // category prefix. A wrong-prefix URL (e.g. /blogs/{workflow-slug}, or an old
        // /mcp/{slug} for a non-MCP article) is 301-redirected to the canonical URL
        // so Google never sees a 404 for a live article.
        $article = Article::with(['category', 'author', 'comments', 'sponsorships.sponsor', 'affiliateLinks'])
            ->where('slug', $slug)
            ->published()
            ->first();

        if (!$article) {
            abort(404);
        }

        // Canonical prefix per category — must mirror Article::getUrlAttribute()
        if ($article->category_id == 1) {
            $canonicalPrefix = 'workflow';
        } elseif ($article->category_id == 5) {
            $canonicalPrefix = 'mcp-directory';
        } else {
            $canonicalPrefix = 'blogs';
        }

        // /mcp/{slug} is a legacy alias for /mcp-directory/{slug}
        $requestedPrefix = $categorySlug === 'mcp' ? 'mcp-directory' : $categorySlug;

        // Wrong category prefix → 301 to the single canonical URL (prevents 404s and duplicate indexing)
        if ($requestedPrefix !== $canonicalPrefix) {
            return redirect($article->url, 301);
        }

        // Increment view count
        $article->increment('view_count');

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

        return view('articles.show', compact(
            'article',
            'relatedArticles',
            'prevArticle',
            'nextArticle',
            'isBookmarked',
            'isSubscribed'
        ));
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
