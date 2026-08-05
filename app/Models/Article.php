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

    /**
     * SEO/AEO-optimized slug generation for new content.
     * Old existing articles keep their original slugs (Google-indexed).
     * New articles get auto-generated, keyword-rich slugs.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Article $article) {
            // Only auto-generate if no slug provided (existing content always has a slug)
            if (empty($article->slug)) {
                $article->slug = static::generateSeoSlug($article->title);
            }

            // Ensure uniqueness
            $article->slug = static::ensureUniqueSlug($article->slug);
        });

        static::updating(function (Article $article) {
            // Never change slug on existing articles — protects Google index
            if ($article->isDirty('slug') && $article->getOriginal('slug')) {
                // If someone explicitly changed the slug, ensure uniqueness
                $article->slug = static::ensureUniqueSlug($article->slug, $article->id);
            }
        });
    }

    /**
     * Generate AEO/SEO-optimized slug from title.
     * - Removes filler/stop words for keyword density
     * - Keeps it under 60 chars for clean SERP URLs
     * - Lowercase, hyphen-separated
     */
    public static function generateSeoSlug(string $title): string
    {
        // Stop words to remove for higher keyword density in URL
        $stopWords = [
            'a', 'an', 'the', 'and', 'or', 'but', 'in', 'on', 'at', 'to',
            'for', 'of', 'with', 'by', 'from', 'is', 'it', 'as', 'be',
            'was', 'are', 'were', 'been', 'being', 'have', 'has', 'had',
            'do', 'does', 'did', 'will', 'would', 'could', 'should',
            'may', 'might', 'shall', 'can', 'that', 'this', 'these',
            'those', 'what', 'which', 'who', 'whom', 'how', 'when',
            'where', 'why', 'not', 'no', 'nor', 'so', 'than', 'too',
            'very', 'just', 'about', 'into', 'your', 'you', 'our',
            'its', 'his', 'her', 'their', 'my',
        ];

        // Convert to lowercase slug first
        $slug = Str::slug($title);

        // Split into words, remove stop words, keep keyword-rich terms
        $words = explode('-', $slug);
        $filtered = array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 1;
        });

        // Rejoin and trim to ~60 chars for clean SERP display
        $slug = implode('-', $filtered);

        // Trim to max 60 characters at word boundary
        if (strlen($slug) > 60) {
            $slug = substr($slug, 0, 60);
            $slug = preg_replace('/-[^-]*$/', '', $slug); // don't cut mid-word
        }

        return $slug ?: Str::slug($title); // fallback to full slug if filtering empties it
    }

    /**
     * Ensure slug is unique by appending -2, -3, etc. if needed.
     */
    public static function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if (!$query->exists()) {
            return $slug;
        }

        $i = 2;
        while (static::where('slug', "{$slug}-{$i}")->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $i++;
        }

        return "{$slug}-{$i}";
    }


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

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
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

    public function getUrlAttribute(): string
    {
        // Match production parent category URL structure
        // AI Workflows (category_id=1) → /workflow/{slug}
        // AI Tools / MCP (category_id=5) → /mcp-directory/{slug}
        // All other categories → /blogs/{slug}
        if ($this->category_id == 1) {
            $categorySlug = 'workflow';
        } elseif ($this->category_id == 5) {
            $categorySlug = 'mcp-directory';
        } else {
            $categorySlug = 'blogs';
        }

        return route('articles.show', ['categorySlug' => $categorySlug, 'slug' => $this->slug]);
    }

    /**
     * Dynamically parse Table of Contents items from H2 headings & FAQs.
     */
    public function getTocAttribute(): array
    {
        $toc = [];
        // Normalize literal '\n' string escapes to actual newlines
        $content = str_replace(["\r\n", '\r\n', '\n'], "\n", $this->content ?? '');

        // 1. Extract markdown H2 headings (lines starting with ## )
        preg_match_all('/^##\s+(.+)$/m', $content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $headingText) {
                // Remove inline markdown syntax, HTML tags, and trailing colons/hashes
                $cleanTitle = trim(strip_tags(preg_replace('/[*_`#]/', '', $headingText)));
                $cleanTitle = rtrim($cleanTitle, ':');
                
                if (!empty($cleanTitle) && strlen($cleanTitle) < 150) {
                    $toc[] = [
                        'number' => count($toc) + 1,
                        'title' => $cleanTitle,
                        'id' => Str::slug($cleanTitle),
                    ];
                }
            }
        }

        // 2. Fallback: Parse rendered HTML <h2> tags if no markdown ## headings were found
        if (empty($toc)) {
            $html = Str::markdown($content);
            preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $html, $htmlMatches);
            if (!empty($htmlMatches[1])) {
                foreach ($htmlMatches[1] as $headingText) {
                    $cleanTitle = trim(strip_tags($headingText));
                    if (!empty($cleanTitle) && strlen($cleanTitle) < 150) {
                        $toc[] = [
                            'number' => count($toc) + 1,
                            'title' => $cleanTitle,
                            'id' => Str::slug($cleanTitle),
                        ];
                    }
                }
            }
        }

        // 3. Append FAQs if present
        if (!empty($this->faqs) && is_array($this->faqs)) {
            $toc[] = [
                'number' => count($toc) + 1,
                'title' => 'FAQs',
                'id' => 'faqs',
            ];
        }

        return $toc;
    }

    /**
     * Render Markdown content to HTML and inject ID attributes into H2 headings for TOC anchors.
     */
    public function getFormattedContentAttribute(): string
    {
        $content = str_replace(["\r\n", '\r\n', '\n'], "\n", $this->content ?? '');
        $html = Str::markdown($content);

        // Inject id="heading-slug" and scroll-mt-24 into every <h2> tag
        return preg_replace_callback('/<h2([^>]*)>(.*?)<\/h2>/i', function ($matches) {
            $attrs = $matches[1];
            $title = trim(strip_tags($matches[2]));
            $slug = Str::slug($title);

            // Avoid duplicate id attribute
            if (str_contains($attrs, 'id=')) {
                return "<h2{$attrs}>{$matches[2]}</h2>";
            }

            return "<h2 id=\"{$slug}\" class=\"scroll-mt-24\"{$attrs}>{$matches[2]}</h2>";
        }, $html);
    }
}
