<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    public function getPublishedHero(): ?Article;
    public function getFeatured(int $limit = 4): Collection;
    public function getTrending(int $limit = 5): Collection;
    public function getLatestPaginated(int $perPage = 10): LengthAwarePaginator;
    public function findBySlug(string $slug): ?Article;
    public function getByCategory(int $categoryId, int $limit = 4): Collection;
}
