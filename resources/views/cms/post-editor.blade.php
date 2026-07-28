@extends('layouts.cms')

@section('title', 'Notion/Linear Block Editor — Daily AI World Enterprise CMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ title: '', deck: '', categoryId: '1', tier: 'Deep Dive', status: 'draft' }">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between border-b border-[#1F1F2E] pb-4">
        <div class="flex items-center gap-3 font-mono text-xs text-gray-400">
            <a href="{{ route('cms.posts') }}" class="hover:text-white">← All Stories</a>
            <span>/</span>
            <span class="text-amber-400 font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                Editing Draft
            </span>
        </div>

        <div class="flex items-center gap-3 font-mono text-xs">
            <button @click="autosaving = true; setTimeout(() => { autosaving = false; savedAt = 'Just now'; }, 1000)" 
                    class="bg-[#161622] hover:bg-[#242436] border border-[#272738] text-gray-300 px-3 py-1.5 rounded-md font-semibold transition-colors">
                Save Draft
            </button>

            <button onclick="alert('Story published to production network.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-1.5 rounded-md font-semibold transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Publish Dispatch</span>
            </button>
        </div>
    </div>

    <!-- Article Metadata Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-[#14141E] border border-[#272738] rounded-xl p-4 font-mono text-xs">
        <div>
            <label class="block text-gray-400 text-[10px] uppercase font-semibold mb-1">Coverage Desk</label>
            <select class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3 py-1.5 focus:outline-none focus:border-[#8B5CF6]">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-400 text-[10px] uppercase font-semibold mb-1">Editorial Tier</label>
            <select class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3 py-1.5 focus:outline-none focus:border-[#8B5CF6]">
                <option value="Deep Dive">Deep Dive</option>
                <option value="Breaking">Breaking</option>
                <option value="Founder Story">Founder Story</option>
                <option value="Research Breakdown">Research Breakdown</option>
                <option value="Briefing">Briefing</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-400 text-[10px] uppercase font-semibold mb-1">Lead Author</label>
            <select class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3 py-1.5 focus:outline-none focus:border-[#8B5CF6]">
                @foreach($authors as $auth)
                    <option value="{{ $auth->id }}">{{ $auth->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Notion-style Canvas Editor -->
    <div class="space-y-6">
        <!-- Title Input -->
        <input type="text" x-model="title" placeholder="Title for the dispatch..." 
               @input="autosaving = true; setTimeout(() => { autosaving = false; savedAt = 'Just now'; }, 1500)"
               class="w-full bg-transparent border-none text-white font-serif font-extrabold text-3xl sm:text-4xl focus:outline-none focus:ring-0 placeholder-gray-600">

        <!-- Subtitle Deck Input -->
        <textarea x-model="deck" rows="2" placeholder="Subtitle / editorial deck summarizing key findings..." 
                  class="w-full bg-transparent border-none text-gray-300 text-base sm:text-lg focus:outline-none focus:ring-0 placeholder-gray-600 font-sans resize-none"></textarea>

        <!-- Markdown Content Editor Canvas -->
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#272738] pb-3 text-xs font-mono text-gray-400">
                <span>Markdown Body Editor</span>
                <span>Supports JetBrains Mono code & tables</span>
            </div>

            <textarea rows="16" placeholder="## Write your technical dispatch in Markdown...

Use code blocks, quotes, and bullet points." 
                      class="w-full bg-transparent border-none text-white text-sm focus:outline-none focus:ring-0 font-mono leading-relaxed resize-none"></textarea>
        </div>
    </div>

</div>
@endsection
