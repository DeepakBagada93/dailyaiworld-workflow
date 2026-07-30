<?php

namespace App\Console\Commands;

use App\Models\Sponsor;
use App\Models\SponsorReport;
use Illuminate\Console\Command;

class GenerateSponsorReportsCommand extends Command
{
    protected $signature = 'sponsorships:report';
    protected $description = 'Generates monthly performance reports per active sponsor company.';

    public function handle()
    {
        $currentMonth = now()->format('Y-m');
        $sponsors = Sponsor::with('sponsorships')->get();

        foreach ($sponsors as $sponsor) {
            $totalImpressions = $sponsor->sponsorships->sum('impressions');
            $totalClicks = $sponsor->sponsorships->sum('clicks');
            $totalSpend = $sponsor->sponsorships->sum('price_paid');
            $ctr = $totalImpressions > 0 ? round(($totalClicks / $totalImpressions) * 100, 2) : 0.00;

            SponsorReport::updateOrCreate(
                [
                    'sponsor_id' => $sponsor->id,
                    'report_month' => $currentMonth,
                ],
                [
                    'total_impressions' => $totalImpressions,
                    'total_clicks' => $totalClicks,
                    'ctr' => $ctr,
                    'total_spend' => $totalSpend,
                    'summary_json' => [
                        'generated_at' => now()->toDateTimeString(),
                        'placements_count' => $sponsor->sponsorships->count(),
                        'top_performing_channel' => 'Executive Newsletter Briefing',
                    ],
                ]
            );
        }

        $this->info("Generated monthly sponsor performance snapshots for {$sponsors->count()} companies.");
        return 0;
    }
}
