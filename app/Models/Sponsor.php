<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_path',
        'website_url',
        'contact_email',
        'status',
        'notes',
    ];

    public function sponsorships()
    {
        return $table = $this->hasMany(Sponsorship::class);
    }

    public function reports()
    {
        return $this->hasMany(SponsorReport::class);
    }

    public function activeSponsorships()
    {
        return $this->hasMany(Sponsorship::class)->where('status', 'active');
    }
}
