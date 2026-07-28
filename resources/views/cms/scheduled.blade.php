@extends('layouts.cms')

@section('title', 'Scheduled Dispatches — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="font-mono text-xs text-emerald-400 font-bold uppercase">Automated Dispatch Queue</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Scheduled Publications Calendar</h1>
    </div>

    <div class="bg-[#14141E] border border-[#272738] rounded-xl p-8 text-center font-mono text-xs space-y-3">
        <svg class="w-10 h-10 text-[#8B5CF6] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <h3 class="font-serif text-lg font-bold text-white">Next Dispatch: Tomorrow at 6:00 AM EST</h3>
        <p class="text-gray-400 max-w-md mx-auto">Automated cron queue powered by Laravel Scheduler & Hostinger queue workers.</p>
    </div>
</div>
@endsection
