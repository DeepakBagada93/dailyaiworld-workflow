<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsor_id',
        'report_month',
        'total_impressions',
        'total_clicks',
        'ctr',
        'total_spend',
        'summary_json',
    ];

    protected $casts = [
        'summary_json' => 'array',
        'ctr' => 'decimal:2',
        'total_spend' => 'decimal:2',
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
