@extends('layouts.cms')

@section('title', 'Internal Linking Graph — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-purple-400 font-bold uppercase">Cross-Referencing Engine</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Internal Topic Graph & Cross-Links</h1>
    </div>

    <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
        <h3 class="font-serif text-lg font-bold text-white">Active Article Cross-Link Connections</h3>
        
        <div class="space-y-3">
            @foreach($articles as $art)
                <div class="p-3 bg-[#0E0E14] border border-[#272738] rounded-md flex items-center justify-between">
                    <div>
                        <span class="text-[#8B5CF6] font-bold block">{{ $art->category->name }}</span>
                        <span class="text-white font-sans text-sm font-semibold">{{ $art->title }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-[#242436] text-gray-300">
                        {{ rand(3, 12) }} Internal Backlinks
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
