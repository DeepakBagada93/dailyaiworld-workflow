@extends('layouts.cms')

@section('title', 'Revenue Architecture & Monetization — Enterprise CMS')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1F1F2E] pb-6">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-emerald-400 mb-1">
                <span>Revenue Architecture</span>
                <span>•</span>
                <span>v1.1 Monetization Specs</span>
            </div>
            <h1 class="font-serif text-3xl font-extrabold text-white">Executive Revenue Overview</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('cms.sponsors') }}" class="bg-[#161622] hover:bg-[#1E1B2E] border border-[#272738] text-white px-4 py-2 rounded-md text-xs font-semibold flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Manage Sponsors</span>
            </a>
            <a href="{{ route('cms.subscriptions') }}" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>View Subscribers</span>
            </a>
        </div>
    </div>

    <!-- Revenue Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 font-mono">
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Gross Revenue (This Month)</span>
            <div class="text-3xl font-extrabold text-emerald-400 mt-2 font-serif">${{ number_format($totalRevenueMonth, 2) }}</div>
            <div class="mt-2 text-[10px] text-emerald-400 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>+34.2% MoM Revenue Velocity</span>
            </div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Monthly Recurring Revenue (MRR)</span>
            <div class="text-3xl font-extrabold text-[#8B5CF6] mt-2 font-serif">${{ number_format($mrr, 2) }}</div>
            <div class="mt-2 text-[10px] text-gray-400">ARR: ${{ number_format($arr, 2) }}</div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Sponsorship Bookings</span>
            <div class="text-3xl font-extrabold text-white mt-2 font-serif">${{ number_format($sponsorshipRevenue, 2) }}</div>
            <div class="mt-2 text-[10px] text-purple-400">{{ $activeSponsorships->count() }} Active Campaigns</div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-5 shadow-lg">
            <span class="text-[11px] text-gray-400 uppercase tracking-wider font-medium">Affiliate Commission Yield</span>
            <div class="text-3xl font-extrabold text-sky-400 mt-2 font-serif">${{ number_format($affiliateRevenue, 2) }}</div>
            <div class="mt-2 text-[10px] text-gray-400">Tool & API Referral Links</div>
        </div>
    </div>

    <!-- Active Sponsorship Placements & Affiliate Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Active Sponsorship Placements -->
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-[#272738] pb-4 mb-4">
                <h3 class="font-serif text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span>Active Sponsorship Campaigns</span>
                </h3>
                <span class="font-mono text-xs text-gray-400 font-semibold">{{ $activeSponsorships->count() }} Live</span>
            </div>

            <div class="space-y-4 font-mono text-xs">
                @forelse($activeSponsorships as $sponsorship)
                    <div class="bg-[#1B1B2A] border border-[#2A2A3E] p-4 rounded-lg flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-white font-bold text-sm">
                                <span>{{ $sponsorship->sponsor->name }}</span>
                                <span class="bg-purple-900/60 text-purple-300 px-2 py-0.5 rounded text-[10px] font-mono border border-purple-700/50">
                                    {{ strtoupper(str_replace('_', ' ', $sponsorship->placement_type)) }}
                                </span>
                            </div>
                            <p class="text-gray-400 text-[11px] font-sans mt-1 line-clamp-1">"{{ $sponsorship->custom_copy }}"</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-emerald-400 font-bold">${{ number_format($sponsorship->price_paid) }}</span>
                            <span class="text-[10px] text-gray-500 block">{{ number_format($sponsorship->clicks) }} Clicks</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs py-4 text-center">No active sponsorship campaigns currently running.</p>
                @endforelse
            </div>
        </div>

        <!-- Top Performing Affiliate Links -->
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6">
            <div class="flex items-center justify-between border-b border-[#272738] pb-4 mb-4">
                <h3 class="font-serif text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    <span>Top Affiliate Referral Links</span>
                </h3>
                <span class="font-mono text-xs text-gray-400 font-semibold">{{ $affiliateLinks->count() }} Monitored</span>
            </div>

            <div class="space-y-3 font-mono text-xs">
                @forelse($affiliateLinks as $link)
                    <div class="bg-[#1B1B2A] border border-[#2A2A3E] p-3.5 rounded-lg flex items-center justify-between">
                        <div>
                            <span class="block text-white font-semibold text-xs">{{ $link->label }}</span>
                            <span class="text-[10px] text-gray-500 block truncate max-w-xs">{{ $link->url }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-sky-400 font-bold">${{ number_format($link->revenue_earned, 2) }}</span>
                            <span class="text-[10px] text-gray-400 block">{{ number_format($link->click_count) }} Clicks</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-xs py-4 text-center">No affiliate links recorded yet.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
