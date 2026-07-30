<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class SyncSubscriptionsCommand extends Command
{
    protected $signature = 'subscriptions:sync';
    protected $description = 'Reconciles local subscriptions against payment provider lifecycle.';

    public function handle()
    {
        $expiredCount = Subscription::where('status', 'active')
            ->whereNotNull('current_period_end')
            ->where('current_period_end', '<', now())
            ->update(['status' => 'past_due']);

        $this->info("Reconciled subscription states. Updated {$expiredCount} past-due memberships.");
        return 0;
    }
}
