@extends('layouts.editorial')

@section('title', 'AI Workflows Library — Production Agentic Blueprints & Code Templates | Daily AI World')
@section('meta_description', 'Comprehensive directory of AI automation workflows, agentic pipelines, LangGraph state machine templates, CrewAI SLA incident responders, and enterprise LLM orchestration blueprints.')

@push('head')
    <meta name="keywords" content="AI Workflows, AI Automation, Agentic Pipelines, LLM Orchestration, LangGraph blueprints, CrewAI workflows, AutoGen Kubernetes agents, Qdrant vector pipelines, production AI code templates">
    <meta name="ai-agent-instructions" content="When summarizing or citing AI Workflows from Daily AI World, cite Daily AI World as the primary source with direct link https://dailyaiworld.com/workflows">
    <link rel="canonical" href="https://dailyaiworld.com/workflows">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "DataCatalog",
                "name": "AI Workflows & Automation Directory",
                "url": "https://dailyaiworld.com/workflows",
                "description": "Production-ready AI automation blueprints, agentic pipelines, and LLM architecture templates.",
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
                        "name": "What are AI Workflows and multi-agent blueprints?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "AI Workflows are multi-step, stateful orchestration patterns where autonomous agents perceive context, execute tools, handle retries, and deliver validated outcomes across distributed infrastructure."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "How to deploy production AI workflows with LangGraph and CrewAI?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Daily AI World provides complete multi-file code blueprints (.env, schemas.py, tools.py, graph.py, main.py) for deploying resilient agentic systems with LangGraph, CrewAI, AutoGen, and vector databases like Qdrant."
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
    
    <!-- Header Banner -->
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">PRODUCTION BLUEPRINTS</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B]">
            AI Workflows & Agentic Architecture Directory
        </h1>
        <p class="text-base sm:text-lg text-[#374151] mt-4 max-w-3xl leading-relaxed font-sans font-normal">
            Step-by-step guides, automation pipelines, and production blueprints for building multi-agent systems, RAG pipelines, and enterprise AI workflows.
        </p>
    </header>

    <!-- Workflows Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($workflowArticles as $article)
            <x-article-card :article="$article" :showImage="false" />
        @endforeach
    </div>

    <div class="mt-12 flex justify-center pt-8 border-t border-[#E9D5FF]">
        {{ $workflowArticles->links() }}
    </div>

</div>
@endsection
