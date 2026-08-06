@extends('layouts.editorial')

@section('title', 'Realtime AI News & Breaking Dispatches — Daily AI World')
@section('meta_description', 'Real-time breaking dispatches, news analysis, model releases, and compute updates across the global artificial intelligence landscape.')

@push('head')
    <link rel="canonical" href="{{ url()->current() }}">
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "DataCatalog",
        "name": "Realtime AI News & Breaking Dispatches",
        "description": "Real-time AI news analysis and technical dispatches.",
        "publisher": {
            "@@type": "Organization",
            "name": "Daily AI World",
            "url": "{{ url('/') }}"
        }
    }
    </script>
@endpush

@section('content')
<div class="future-newsroom newsroom-page max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">REALTIME NEWS DESK</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B]">
            Latest Artificial Intelligence News & Dispatches
        </h1>
        <p class="text-base sm:text-lg text-[#374151] mt-4 max-w-3xl leading-relaxed font-sans font-normal">
            Continuous coverage of model releases, agentic tools, AI compute infrastructure, and SaaS industry shifts.
        </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($latestNews as $article)
            <x-article-card :article="$article" :showImage="false" />
        @endforeach
    </div>

    <div class="mt-12 flex justify-center pt-8 border-t border-[#E9D5FF]">
        {{ $latestNews->links() }}
    </div>

</div>
@endsection
