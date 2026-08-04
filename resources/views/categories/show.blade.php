@extends('layouts.editorial')

@section('title', $category->name . ' — Daily AI World')
@section('meta_description', $category->description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    <!-- Category Desk Header Banner (Minimalist Magazine Style) -->
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->accent_color ?? '#6D28D9' }}"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">EDITORIAL DESK ARCHIVE</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B]">
            {{ $category->name }}
        </h1>
        @if($category->description)
            <p class="text-base sm:text-lg text-[#374151] mt-4 max-w-3xl leading-relaxed font-sans font-normal">
                {{ $category->description }}
            </p>
        @endif
    </header>

    <!-- Text-Based Articles Grid (No Images) -->
    @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <x-article-card :article="$article" :showImage="false" />
            @endforeach
        </div>

        <div class="mt-12 flex justify-center pt-8 border-t border-[#E9D5FF]">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-[#FAF5FF] rounded-2xl border border-[#E9D5FF]">
            <h3 class="font-sans text-xl font-bold text-[#1E1B4B]">No stories published in this desk yet.</h3>
            <p class="text-xs text-[#6B7280] mt-2 font-mono">Check back for fresh realtime dispatches.</p>
        </div>
    @endif

</div>
@endsection
