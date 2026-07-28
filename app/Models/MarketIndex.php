<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketIndex extends Model
{
    use HasFactory;

    protected $table = 'market_indices';

    protected $fillable = [
        'symbol',
        'name',
        'value',
        'change_pct',
        'direction',
        'type',
    ];
}
