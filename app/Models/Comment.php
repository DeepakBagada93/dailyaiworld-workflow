<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'name',
        'email',
        'content',
        'is_approved',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->format('M d, Y \a\t g:i A') : '';
    }
}
