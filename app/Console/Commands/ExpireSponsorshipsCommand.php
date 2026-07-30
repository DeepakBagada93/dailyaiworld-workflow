<?php

namespace App\Console\Commands;

use App\Models\Sponsorship;
use Illuminate\Console\Command;

class ExpireSponsorshipsCommand extends Command
{
    protected $signature = 'sponsorships:expire';
    protected $description = 'Flips active sponsorships to expired if end_date has passed.';

    public function handle()
    {
        $expiredCount = Sponsorship::where('status', 'active')
            ->where('end_date', '<', now()->startOfDay())
            ->update(['status' => 'expired']);

        $this->info("Expired {$expiredCount} sponsorship campaigns.");
        return 0;
    }
}
