@extends('layouts.editorial')

@section('title', 'Editorial and Legal Disclaimer — Daily AI World')
@section('meta_description', 'Editorial and Legal Disclaimer for Daily AI World. Information regarding code examples, benchmarks, AI disclosures, and trademark attributions.')
@section('meta_keywords', 'Editorial Disclaimer, Legal Notice, AI Disclosures, Daily AI World, Benchmark Disclaimer')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-[#6B7280] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5B21B6] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#5B21B6] font-semibold">Disclaimer</span>
        </div>

        <div class="border-b border-[#E5E7EB] pb-8 mb-8">
            <div class="inline-flex items-center gap-2 bg-[#FAF5FF] border border-[#E9D5FF] text-[#5B21B6] px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-4">
                <span>EDITORIAL & TECHNICAL DISCLOSURES</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] tracking-tight">
                Disclaimer & Disclosures
            </h1>
            <p class="mt-3 text-sm font-mono text-[#6B7280]">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>

        <!-- Document Content -->
        <article class="prose prose-purple max-w-none text-[#374151] leading-relaxed space-y-8 font-sans">
            
            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">1. Technical & Engineering Information</h2>
                <p>
                    The technical tutorials, architectural workflows, Model Context Protocol (MCP) server blueprints, and code repositories presented on <strong>Daily AI World</strong> are intended for educational and architectural reference purposes. While code examples are rigorously tested in isolated sandbox environments, software versions, API endpoints, rate limits, and third-party SDK dependencies change frequently.
                </p>
                <p>
                    You are strongly advised to audit, sandbox, and perform security reviews on any code or workflow before deploying it into critical enterprise production systems. Daily AI World and SaaSNext assume no responsibility for system downtime, API overages, or regressions.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">2. No Financial or Investment Advice</h2>
                <p>
                    Any references to market tickers, token pricing, API unit costs, enterprise software evaluations, or publicly traded AI companies (such as NVIDIA, Alphabet, Microsoft, Apple, or Amazon) are provided solely for editorial analysis and industry commentary. Nothing on this website constitutes financial, legal, or investment advice.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">3. AI Disclosure & Editorial Oversight</h2>
                <p>
                    Daily AI World utilizes modern agentic AI tooling and automated CI/CD pipelines to assist with research clustering, synthetic benchmark verification, and grammatical formatting. However, all dispatches, code schemas, and architectural guidelines undergo strict human editorial oversight and validation led by Chief Editor Deepak Bagada and the SaaSNext engineering team.
                </p>
            </section>

            <section class="space-y-3 bg-[#FAF5FF] p-6 rounded-2xl border border-[#E9D5FF]">
                <h2 class="text-xl font-bold font-serif text-[#1E1B4B]">4. Advertising & Affiliate Disclosure</h2>
                <p class="text-sm text-[#374151]">
                    Daily AI World participates in digital advertising networks (including Google AdSense) and select developer tooling affiliate programs. Some external links to developer platforms, cloud providers, or SaaS products may be affiliate links. If you click on an affiliate link and make a purchase or subscribe to a paid tier, Daily AI World may receive an affiliate commission at no extra cost to you.
                </p>
                <p class="text-sm text-[#374151]">
                    Our editorial integrity, code benchmarks, and architectural evaluations remain strictly independent and impartial. We never accept compensation in exchange for positive architectural reviews, and all sponsored dispatches or brand integrations are explicitly labeled with sponsor attribution.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">5. Trademark Notice</h2>
                <p>
                    All product names, logos, trademarks, and registered trademarks mentioned on Daily AI World (including but not limited to Claude, Anthropic, OpenAI, ChatGPT, Google Gemini, DeepSeek, Meta Llama, Cursor, LangChain, LangGraph, and CrewAI) are the property of their respective owners. Their inclusion does not imply any affiliation, sponsorship, or endorsement.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">6. Inquiries</h2>
                <p>
                    For legal, affiliate, or disclosure inquiries, reach out to <a href="mailto:connect@saasnext.in" class="text-[#5B21B6] font-semibold underline">connect@saasnext.in</a>.
                </p>
            </section>

        </article>
    </div>
</div>
@endsection
