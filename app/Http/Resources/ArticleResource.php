<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'deck' => $this->deck,
            'ai_summary' => $this->ai_summary,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'reading_time' => $this->reading_time,
            'tier' => $this->tier,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'key_takeaways' => $this->key_takeaways,
            'faqs' => $this->faqs,
            'published_at' => $this->formatted_date,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
