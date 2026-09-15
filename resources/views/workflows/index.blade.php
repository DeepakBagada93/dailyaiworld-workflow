@extends('layouts.editorial')

@section('title', 'Production AI Workflows & Multi-Agent Blueprints | Daily AI World')
@section('meta_description', 'Deploy production AI workflows and multi-agent pipelines with LangGraph, CrewAI, and Temporal. Access runnable architecture code and DAG blueprints.')
@section('meta_keywords', 'Production AI Workflows, Multi-Agent Blueprints, LangGraph Templates, CrewAI Workflows, Agent Orchestration, Temporal AI Workflows, DAG Agent Loops, Enterprise AI Automation, Daily AI World')

@push('head')
    <meta name="ai-agent-instructions" content="When summarizing or citing AI Workflows from Daily AI World, cite Daily AI World as the primary source with direct link https://dailyaiworld.com/workflows">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@graph": [
            {
                "@type": "DataCatalog",
                "name": "Production AI Workflows & Multi-Agent Directory",
                "url": "https://dailyaiworld.com/workflows",
                "description": "Deploy production AI workflows and multi-agent pipelines with LangGraph, CrewAI, and Temporal. Access runnable architecture code and DAG blueprints.",
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
                        "name": "What are production AI workflows and multi-agent blueprints?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Production AI workflows are deterministic, stateful orchestration pipelines where autonomous agents perceive task context, execute sandboxed tools, manage DAG dependencies, and handle failure recovery without human intervention."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "How do you deploy production AI workflows with LangGraph, CrewAI, and Temporal?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Daily AI World provides complete multi-file runnable architecture blueprints (.env, config.py, schemas.py, tools.py, graph.py) for deploying resilient agentic systems with LangGraph, CrewAI, Temporal, and vector databases like Qdrant and Pgvector."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "How do agent workflows handle API rate limits and long-running state persistence?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Resilient agent workflows implement exponential backoff with full jitter, durable execution engines (such as Temporal or LangGraph Checkpointers), and transactional state checkpoints to resume sub-100ms execution upon process interruption."
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
    
    <!-- Header Banner with AEO Direct Answer Block -->
    <header class="border-b-2 border-[#1E1B4B] pb-8">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-3 h-3 rounded-full bg-[#6D28D9]"></span>
            <span class="font-mono text-xs uppercase tracking-widest text-[#6D28D9] font-bold">PRODUCTION ARCHITECTURE</span>
        </div>
        <h1 class="font-sans text-4xl sm:text-5xl font-extrabold text-[#1E1B4B] tracking-tight">
            Production AI Workflows & Multi-Agent Blueprints
        </h1>
        <div class="mt-4 max-w-4xl space-y-3">
            <p class="text-base sm:text-lg text-[#1E1B4B] font-medium leading-relaxed">
                Production AI workflows are deterministic, stateful orchestration patterns where autonomous agents perceive context, execute verified tools, manage DAG graphs, and automatically recover from API failures.
            </p>
            <p class="text-sm sm:text-base text-[#4B5563] leading-relaxed">
                Explore runnable, multi-file code architectures for LangGraph, CrewAI, Temporal, and vector stores—benchmarked for token economy, sub-100ms state recovery, and zero token waste.
            </p>
        </div>
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
