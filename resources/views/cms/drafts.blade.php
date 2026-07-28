@extends('layouts.cms')

@section('title', 'Drafts Workspace — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <div class="border-b border-[#1F1F2E] pb-6 flex items-center justify-between">
        <div>
            <span class="font-mono text-xs text-amber-400 font-bold uppercase">Work In Progress</span>
            <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Drafts & In-Progress Dispatches</h1>
        </div>
        <a href="{{ route('cms.posts.create') }}" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold font-mono">
            + New Draft
        </a>
    </div>

    @if($drafts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($drafts as $draft)
                <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 hover:border-[#8B5CF6] transition-colors space-y-3 font-mono text-xs">
                    <div class="flex items-center justify-between text-gray-400">
                        <span class="text-[#8B5CF6] font-semibold">{{ $draft->category->name }}</span>
                        <span>Updated {{ $draft->updated_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('cms.posts.create') }}" class="block font-serif text-xl font-bold text-white hover:text-[#8B5CF6]">
                        {{ $draft->title }}
                    </a>
                    <p class="text-gray-400 font-sans text-xs line-clamp-2">{{ $draft->deck ?? $draft->excerpt }}</p>
                    <div class="pt-3 border-t border-[#272738] flex items-center justify-between text-gray-500">
                        <span>By {{ $draft->author->name }}</span>
                        <a href="{{ route('cms.posts.create') }}" class="text-[#8B5CF6] font-semibold hover:underline">Resume Editing →</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-[#14141E] border border-[#272738] rounded-xl font-mono text-xs">
            <svg class="w-10 h-10 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <h3 class="font-serif text-lg font-bold text-white">No active drafts</h3>
            <p class="text-gray-500 mt-1">All editorial dispatches have been published to production.</p>
        </div>
    @endif
</div>
@endsection
