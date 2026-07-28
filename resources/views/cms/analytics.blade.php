@extends('layouts.cms')

@section('title', 'Analytics — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-sky-400 font-bold uppercase">Traffic & Readership Metrics</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Readership Analytics</h1>
    </div>

    <!-- Traffic Chart Simulation (Vercel Style) -->
    <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-serif text-lg font-bold text-white">Daily Page Views (Last 30 Days)</h3>
            <span class="text-emerald-400 font-bold">+34.2% YoY</span>
        </div>

        <div class="h-48 flex items-end justify-between gap-2 pt-6">
            @for($i = 0; $i < 30; $i++)
                @php $h = rand(30, 95); @endphp
                <div class="w-full bg-[#8B5CF6]/30 hover:bg-[#8B5CF6] rounded-t transition-all group relative" style="height: {{ $h }}%">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 hidden group-hover:block bg-[#242436] text-white px-2 py-1 rounded text-[9px] whitespace-nowrap">
                        {{ number_format($h * 420) }} views
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
