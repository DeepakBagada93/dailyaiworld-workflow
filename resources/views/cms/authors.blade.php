@extends('layouts.cms')

@section('title', 'Columnists — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="border-b border-[#1F1F2E] pb-6 flex items-center justify-between">
        <div>
            <span class="font-mono text-xs text-cyan-400 font-bold uppercase">Editorial Roster</span>
            <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Columnists & Scholars</h1>
        </div>
        <button onclick="alert('Author invitation modal opened.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold font-mono">
            + Invite Columnist
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
        @foreach($authors as $author)
            <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 flex items-start gap-4">
                @if($author->avatar)
                    <img src="{{ $author->avatar }}" class="w-14 h-14 rounded-full object-cover border border-[#272738] shrink-0">
                @endif
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif text-lg font-bold text-white">{{ $author->name }}</h3>
                        <span class="px-2 py-0.5 rounded bg-[#242436] text-cyan-300 font-bold text-[10px]">
                            {{ $author->articles_count }} Dispatches
                        </span>
                    </div>
                    <p class="text-xs text-[#8B5CF6] font-semibold">{{ $author->title }}</p>
                    <p class="text-gray-400 font-sans text-xs line-clamp-2">{{ $author->bio }}</p>
                    <div class="pt-2 text-[11px] text-gray-500 flex items-center gap-4">
                        <span>{{ $author->twitter }}</span>
                        <span>•</span>
                        <button class="text-white hover:underline">Edit Bio</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
