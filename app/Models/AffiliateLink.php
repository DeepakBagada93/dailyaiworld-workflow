<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'label',
        'url',
        'disclosure_text',
        'click_count',
        'revenue_earned',
    ];

    protected $casts = [
        'revenue_earned' => 'decimal:2',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
