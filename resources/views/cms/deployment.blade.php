@extends('layouts.cms')

@section('title', 'Deployment & CI/CD — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6 flex items-center justify-between">
        <div>
            <span class="text-[#8B5CF6] font-bold uppercase">Build Pipeline & GitHub Activity</span>
            <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Deployment Logs & CI/CD</h1>
        </div>
        <button onclick="alert('Manual deployment triggered.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md font-semibold">
            Trigger Rebuild
        </button>
    </div>

    <!-- Live Deployment Terminal Log -->
    <div class="bg-[#0E0E14] border border-[#272738] rounded-xl p-5 font-mono text-xs text-gray-300 space-y-2">
        <div class="flex items-center justify-between border-b border-[#272738] pb-2 text-gray-500 text-[11px]">
            <span>Vercel / Hostinger Production Build Log</span>
            <span class="text-emerald-400 font-bold">● SUCCESS (Built in 112ms)</span>
        </div>
        <div class="text-purple-400">$ git checkout main && git pull origin main</div>
        <div class="text-gray-400">> vite build v8.1.5 building client environment...</div>
        <div class="text-gray-400">✓ 4 modules transformed.</div>
        <div class="text-emerald-400">public/build/assets/app-DBWjdMdC.css 73.35 kB │ gzip: 14.67 kB</div>
        <div class="text-emerald-400">public/build/assets/app-B9qO1Jfl.js 45.26 kB │ gzip: 16.11 kB</div>
        <div class="text-gray-500 pt-2">> Cache invalidated across 12 edge CDN nodes.</div>
    </div>
</div>
@endsection
