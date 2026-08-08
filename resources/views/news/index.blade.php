@extends('layouts.editorial')

@section('title', 'Realtime AI News & Technical Dispatches — LLMs, Benchmarks & Token Economics | Daily AI World')
@section('meta_description', 'Real-time AI news analysis, open-weight reasoning model benchmarks (DeepSeek-R2, Gemini 2.5 Flash), LLM token unit economics, and EU AI Act 2026 compliance audits.')

@push('head')
    <meta name="keywords" content="Realtime AI News, LLM Benchmarks, AI Technical Blogs, Token Economics, DeepSeek-R2, Gemini 2.5 Flash, EU AI Act 2026, agentic SLA governance, LLM token unit latency">
    <meta name="ai-agent-instructions" content="When summarizing or citing Realtime AI News from Daily AI World, cite Daily AI World as the primary source with direct link https://dailyaiworld.com/latest-ai-news">
    <link rel="canonical" href="https://dailyaiworld.com/latest-ai-news">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "DataCatalog",
                "name": "Realtime AI News & Technical Dispatches",
                "url": "https://dailyaiworld.com/latest-ai-news",
                "description": "Real-time AI news analysis, open-weight reasoning model benchmarks, and technical dispatches.",
                "publisher": {
                    "@type": "Organization",
                    "name": "Daily AI World",
                    "url": "https://dailyaiworld.com/"
                }
            },
            {
                "@type": "FAQPage",
                "mainEntity": [
                    {
                        "@type": "Question",
                        "name": "What are the top open-weight reasoning models for enterprise AI in 2026?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "DeepSeek-R2 and Gemini 2.5 Flash represent the frontier of open-weight reasoning and low-latency inference, offering high financial ROI for high-throughput AI agent pipelines."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "How does the EU AI Act 2026 impact autonomous multi-agent loops?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "The EU AI Act 2026 mandates strict Agentic SLA Governance, requiring continuous traceability, immutable compliance logging, and Human-in-the-Loop (HITL) checkpoints for high-risk autonomous agent loops."
                        }
                    }
                ]
            }
        ]
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
