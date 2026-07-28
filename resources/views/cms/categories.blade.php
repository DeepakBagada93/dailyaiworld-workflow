@extends('layouts.cms')

@section('title', 'Categories & Desks — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="border-b border-[#1F1F2E] pb-6 flex items-center justify-between">
        <div>
            <span class="font-mono text-xs text-[#8B5CF6] font-bold uppercase">Editorial Desks</span>
            <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Categories & Topic Desks</h1>
        </div>
        <button onclick="alert('Category creation modal opened.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold font-mono">
            + Add New Desk
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 font-mono text-xs">
        @foreach($categories as $cat)
            <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 font-bold text-white text-sm">
                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat->accent_color }}"></span>
                        {{ $cat->name }}
                    </span>
                    <span class="px-2 py-0.5 rounded bg-[#242436] text-[#8B5CF6] font-bold text-[11px]">
                        {{ $cat->articles_count }} Stories
                    </span>
                </div>
                <p class="text-gray-400 font-sans text-xs leading-relaxed">{{ $cat->description }}</p>
                <div class="pt-3 border-t border-[#272738] flex items-center justify-between text-gray-500 text-[11px]">
                    <span>Slug: /category/{{ $cat->slug }}</span>
                    <button class="text-[#8B5CF6] hover:underline">Edit Spec</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
