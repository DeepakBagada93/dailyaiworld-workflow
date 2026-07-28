<?php

namespace App\Actions;

use App\DTOs\ArticleData;
use App\Models\Article;
use Illuminate\Support\Str;

class PublishArticleAction
{
    public function execute(ArticleData $data): Article
    {
        return Article::create(array_merge($data->toArray(), [
            'status' => 'published',
            'published_at' => now(),
            'slug' => $data->slug ?: Str::slug($data->title),
        ]));
    }
}
