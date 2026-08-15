<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getPublishedHero(): ?Article
    {
        // A manually pinned hero (is_hero) is honored only while fresh (last 24h);
        // otherwise the hero always advances to the latest published dispatch so the
        // hero never goes stale behind a pinned story.
        return Article::with(['category', 'author'])
            ->published()
            ->where('is_hero', true)
            ->where('published_at', '>=', now()->subHours(24))
            ->first() ?? Article::with(['category', 'author'])->published()->latest('published_at')->first();
    }

    public function getFeatured(int $limit = 4): Collection
    {
        return Article::with(['category', 'author'])
            ->published()
            ->where('is_featured', true)
            ->take($limit)
            ->get();
    }

    public function getTrending(int $limit = 5): Collection
    {
        return Article::with(['category', 'author'])
            ->trending()
            ->take($limit)
            ->get();
    }

    public function getLatestPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): ?Article
    {
        return Article::with(['category', 'author', 'comments'])
            ->where('slug', $slug)
            ->published()
            ->first();
    }

    public function getByCategory(int $categoryId, int $limit = 4): Collection
    {
        return Article::with(['category', 'author'])
            ->published()
            ->where('category_id', $categoryId)
            ->latest('published_at')
            ->take($limit)
            ->get();
    }
}
