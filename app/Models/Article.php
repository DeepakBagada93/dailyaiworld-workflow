<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'deck',
        'ai_summary',
        'content',
        'excerpt',
        'featured_image',
        'reading_time',
        'audio_url',
        'key_takeaways',
        'faqs',
        'tier',
        'is_hero',
        'is_featured',
        'status',
        'published_at',
        'updated_date',
        'view_count',
        'trending_score',
    ];

    protected $casts = [
        'key_takeaways' => 'array',
        'faqs' => 'array',
        'is_hero' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'updated_date' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->latest();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeTrending($query)
    {
        return $query->published()->orderBy('trending_score', 'desc');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : '';
    }

    public function getFormattedUpdatedDateAttribute(): string
    {
        return $this->updated_date ? $this->updated_date->format('M d, Y') : ($this->published_at ? $this->published_at->format('M d, Y') : '');
    }

    public function getIsoDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->toIso8601String() : '';
    }

    public function getIsoUpdatedDateAttribute(): string
    {
        return $this->updated_date ? $this->updated_date->toIso8601String() : $this->getIsoDateAttribute();
    }
}
