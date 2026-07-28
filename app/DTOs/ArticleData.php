<?php

namespace App\DTOs;

class ArticleData
{
    public function __construct(
        public string $title,
        public string $slug,
        public ?string $deck,
        public ?string $aiSummary,
        public string $content,
        public int $categoryId,
        public int $authorId,
        public string $tier = 'Deep Dive',
        public int $readingTime = 5,
        public array $keyTakeaways = [],
        public array $faqs = [],
        public bool $isHero = false,
        public bool $isFeatured = false,
    ) {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'deck' => $this->deck,
            'ai_summary' => $this->aiSummary,
            'content' => $this->content,
            'category_id' => $this->categoryId,
            'author_id' => $this->authorId,
            'tier' => $this->tier,
            'reading_time' => $this->readingTime,
            'key_takeaways' => $this->keyTakeaways,
            'faqs' => $this->faqs,
            'is_hero' => $this->isHero,
            'is_featured' => $this->isFeatured,
        ];
    }
}
