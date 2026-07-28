<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'accent_color' => $this->accent_color,
            'icon' => $this->icon,
            'is_featured' => $this->is_featured,
            'articles_count' => $this->whenCounted('articles'),
        ];
    }
}
