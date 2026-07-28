@extends('layouts.cms')

@section('title', 'Research Queue — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-emerald-400 font-bold uppercase">Academic & Industry Preprints</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Research Queue & Industry Signals</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
            <h3 class="font-serif text-lg font-bold text-white">arXiv & Peer-Review Submissions</h3>
            
            <div class="space-y-3">
                <div class="p-3 bg-[#0E0E14] border border-[#272738] rounded-md space-y-1">
                    <span class="text-[10px] text-[#8B5CF6] font-bold">cs.CL • Stanford Vision Lab</span>
                    <h4 class="font-bold text-white font-sans text-sm">Sub-quadratic Attention via State Space Hybridization</h4>
                    <span class="text-gray-500 text-[10px]">Status: Queued for Analysis</span>
                </div>

                <div class="p-3 bg-[#0E0E14] border border-[#272738] rounded-md space-y-1">
                    <span class="text-[10px] text-emerald-400 font-bold">cs.AI • DeepMind Research</span>
                    <h4 class="font-bold text-white font-sans text-sm">Self-Correcting Reasoning Search in Code Models</h4>
                    <span class="text-gray-500 text-[10px]">Status: Review Assigned</span>
                </div>
            </div>
        </div>

        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
            <h3 class="font-serif text-lg font-bold text-white">Hardware & Silicon Signals</h3>
            
            <div class="space-y-3">
                <div class="p-3 bg-[#0E0E14] border border-[#272738] rounded-md flex items-center justify-between">
                    <div>
                        <span class="text-gray-400 block font-bold">H100 SXM Cloud Spot Rate</span>
                        <span class="text-white text-base font-bold">$2.35 / hr</span>
                    </div>
                    <span class="text-rose-400 font-bold">-4.2% (Downward Trend)</span>
                </div>

                <div class="p-3 bg-[#0E0E14] border border-[#272738] rounded-md flex items-center justify-between">
                    <div>
                        <span class="text-gray-400 block font-bold">Blackwell B200 Rack Availability</span>
                        <span class="text-white text-base font-bold">98.2%</span>
                    </div>
                    <span class="text-emerald-400 font-bold">+0.5% (High Capacity)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
