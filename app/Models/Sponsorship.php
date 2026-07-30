<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'placement_type',
        'article_id',
        'start_date',
        'end_date',
        'price_paid',
        'impressions',
        'clicks',
        'status',
        'custom_copy',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_paid' => 'decimal:2',
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
