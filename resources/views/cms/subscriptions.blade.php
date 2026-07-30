@extends('layouts.cms')

@section('title', 'Subscriber Management & MRR — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1F1F2E] pb-6">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-sky-400 mb-1">
                <span>Subscriber Management</span>
                <span>•</span>
                <span>Stripe Membership Integration</span>
            </div>
            <h1 class="font-serif text-3xl font-extrabold text-white">Executive Subscribers & Membership Roster</h1>
        </div>

        <div class="flex items-center gap-3 font-mono text-xs">
            <span class="bg-[#14141E] border border-[#272738] px-3.5 py-2 rounded-md text-emerald-400 font-bold">
                MRR: ${{ number_format($mrr, 2) }}
            </span>
        </div>
    </div>

    <!-- Subscriber Roster Table -->
    <div class="bg-[#14141E] border border-[#272738] rounded-xl overflow-hidden shadow-xl font-mono text-xs">
        <div class="px-6 py-4 border-b border-[#272738] flex items-center justify-between">
            <h3 class="font-serif text-base font-bold text-white">Active & Past Subscriber Members</h3>
            <span class="text-gray-400 text-[11px]">{{ $activeCount }} Active Members</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1B1B2A] text-gray-400 uppercase text-[10px] tracking-wider border-b border-[#272738]">
                        <th class="py-3 px-6">Subscriber Email</th>
                        <th class="py-3 px-6">Plan Tier</th>
                        <th class="py-3 px-6">Amount</th>
                        <th class="py-3 px-6">Stripe Subscription ID</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Renews / End Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F2E] text-gray-300">
                    @forelse($subscriptions as $sub)
                        <tr class="hover:bg-[#1A1A28] transition-colors">
                            <td class="py-4 px-6 font-bold text-white">
                                {{ $sub->email }}
                            </td>
                            <td class="py-4 px-6 uppercase text-purple-400 font-bold">
                                {{ $sub->plan }}
                            </td>
                            <td class="py-4 px-6 font-bold text-emerald-400">
                                ${{ number_format($sub->amount, 2) }}
                            </td>
                            <td class="py-4 px-6 text-gray-500 font-mono text-[11px]">
                                {{ $sub->stripe_subscription_id ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-6">
                                @if($sub->status === 'active')
                                    <span class="bg-emerald-900/60 text-emerald-300 px-2.5 py-1 rounded-full text-[10px] font-bold border border-emerald-700/50">ACTIVE</span>
                                @elseif($sub->status === 'canceled')
                                    <span class="bg-rose-900/60 text-rose-300 px-2.5 py-1 rounded-full text-[10px] font-bold border border-rose-700/50">CANCELED</span>
                                @else
                                    <span class="bg-amber-900/60 text-amber-300 px-2.5 py-1 rounded-full text-[10px] font-bold border border-amber-700/50">{{ strtoupper($sub->status) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-gray-400">
                                {{ $sub->current_period_end ? $sub->current_period_end->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No active subscribers registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div class="p-4 border-t border-[#272738]">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
