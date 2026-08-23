@extends('layouts.editorial')

@section('title', 'About Us & Editorial Standards — Daily AI World')
@section('meta_description', 'About Daily AI World. Learn about our editorial mission, technical validation standards, leadership team led by Deepak Bagada, and our commitment to high-density AI engineering dispatches.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-[#6B7280] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5B21B6] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#5B21B6] font-semibold">About Us</span>
        </div>

        <!-- Hero Section -->
        <div class="border-b border-[#E5E7EB] pb-8 mb-10">
            <div class="inline-flex items-center gap-2 bg-[#FAF5FF] border border-[#E9D5FF] text-[#5B21B6] px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-4">
                <span>OUR MISSION & EDITORIAL PHILOSOPHY</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] tracking-tight leading-tight">
                Engineering-First Intelligence for the Autonomous AI Era
            </h1>
            <p class="mt-4 text-lg text-[#4B5563] leading-relaxed">
                Daily AI World is an independent, technical journal and intelligence portal dedicated to AI founders, machine learning engineers, and software architects building real-world autonomous agent systems and production workflows.
            </p>
        </div>

        <!-- Core Mission & What We Do -->
        <div class="space-y-12 text-[#374151] leading-relaxed">
            
            <section class="space-y-4">
                <h2 class="text-2xl font-serif font-bold text-[#111827]">Why We Built Daily AI World</h2>
                <p>
                    The modern artificial intelligence ecosystem is crowded with generic buzzwords, superficial summaries, and recycled press releases. Developers and technology executives need deep, executable technical breakdowns — complete with real code snippets, token economics benchmarks, Model Context Protocol (MCP) server blueprints, and verifiable architecture patterns.
                </p>
                <p>
                    At <strong>Daily AI World</strong>, we adhere to a strict rule: <em>high density, zero fluff</em>. Every article is engineered to deliver actionable value, production-tested architectural designs, and real benchmarks comparing models like Claude 3.7 Sonnet, DeepSeek-R1/V3, OpenAI o3-mini, and open-weights powerhouses like Qwen 2.5 Coder and Llama 3.3.
                </p>
            </section>

            <!-- Pillar Grid -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                <div class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#5B21B6] text-white flex items-center justify-center font-bold text-sm">01</div>
                    <h3 class="font-serif font-bold text-lg text-[#1E1B4B]">Autonomous Workflows</h3>
                    <p class="text-sm text-[#4B5563]">End-to-end orchestration designs with LangGraph, CrewAI, AutoGen, and PydanticAI with stateful memory and recovery.</p>
                </div>
                <div class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#5B21B6] text-white flex items-center justify-center font-bold text-sm">02</div>
                    <h3 class="font-serif font-bold text-lg text-[#1E1B4B]">MCP Directory & Tools</h3>
                    <p class="text-sm text-[#4B5563]">Production-ready FastMCP server implementations connecting Claude, Cursor, and IDEs to databases, APIs, and microservices.</p>
                </div>
                <div class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-[#5B21B6] text-white flex items-center justify-center font-bold text-sm">03</div>
                    <h3 class="font-serif font-bold text-lg text-[#1E1B4B]">Empirical Benchmarks</h3>
                    <p class="text-sm text-[#4B5563]">Unbiased evaluations of token throughput, inference unit latency, context window degradation, and reasoning precision.</p>
                </div>
            </section>

            <!-- Editorial Standards & E-E-A-T -->
            <section class="space-y-4 pt-4 border-t border-[#E5E7EB]">
                <h2 class="text-2xl font-serif font-bold text-[#111827]">Editorial Standards & Fact-Checking</h2>
                <p>
                    To ensure the highest standard of <strong>Experience, Expertise, Authoritativeness, and Trustworthiness (E-E-A-T)</strong>:
                </p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Code Verification:</strong> All code examples (Python, TypeScript, SQL, Bash) are executed and validated in sandbox test harnesses before publication.</li>
                    <li><strong>Citation Integrity:</strong> Benchmark dispatches directly cite primary research papers (arXiv), official API documentation, and public repository commits.</li>
                    <li><strong>Editorial Independence:</strong> Technical reviews and comparisons are impartial and not influenced by commercial sponsorships. Sponsored dispatches are always explicitly disclosed.</li>
                </ul>
            </section>

            <!-- Founder & Leadership Team -->
            <section class="pt-4 border-t border-[#E5E7EB]">
                <h2 class="text-2xl font-serif font-bold text-[#111827] mb-6">Leadership & Editorial Team</h2>
                <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row gap-6 items-start shadow-xs">
                    <img src="{{ asset('images/logo.png') }}" alt="Deepak Bagada" class="w-20 h-20 rounded-2xl object-cover bg-purple-100 border border-[#E9D5FF] shrink-0">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-xl font-bold font-serif text-[#111827]">Deepak Bagada</h3>
                            <span class="text-xs font-mono bg-[#FAF5FF] text-[#5B21B6] border border-[#E9D5FF] px-2.5 py-0.5 rounded-md font-semibold">Founder & Chief Editor</span>
                        </div>
                        <p class="text-xs font-mono text-[#6B7280]">CEO at SaaSNext · AI Engineer & System Architect</p>
                        <p class="text-sm text-[#4B5563] pt-2">
                            Deepak leads the architecture, AI research curation, and technical review standards at Daily AI World. With years of hands-on experience in cloud infrastructure, autonomous agent orchestration, and SaaS development, he ensures every dispatch meets enterprise engineering rigor.
                        </p>
                        <div class="flex items-center gap-4 pt-3 text-xs font-mono text-[#5B21B6]">
                            <a href="https://deepakbagada.in" target="_blank" rel="noopener noreferrer" class="hover:underline font-semibold flex items-center gap-1">
                                <span>Personal Portfolio ↗</span>
                            </a>
                            <span>·</span>
                            <a href="https://x.com/deeepakbagada" target="_blank" rel="noopener noreferrer" class="hover:underline font-semibold flex items-center gap-1">
                                <span>X (@deeepakbagada) ↗</span>
                            </a>
                            <span>·</span>
                            <a href="https://github.com/DeepakBagada93" target="_blank" rel="noopener noreferrer" class="hover:underline font-semibold flex items-center gap-1">
                                <span>GitHub ↗</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Parent Organization & Contact -->
            <section class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6 sm:p-8 space-y-4">
                <h3 class="text-lg font-serif font-bold text-[#1E1B4B]">Organization & Publisher Information</h3>
                <p class="text-sm text-[#4B5563]">
                    Daily AI World is published by <strong>SaaSNext</strong>, an AI engineering studio building digital products and developer tooling.
                </p>
                <div class="flex flex-wrap gap-4 text-xs font-mono text-[#5B21B6]">
                    <a href="{{ route('contact') }}" class="px-4 py-2 bg-[#5B21B6] text-white rounded-lg font-bold hover:bg-[#4C1D95] transition-colors">
                        Contact Editorial Desk
                    </a>
                    <a href="{{ route('advertise') }}" class="px-4 py-2 bg-white text-[#5B21B6] border border-[#E9D5FF] rounded-lg font-bold hover:bg-purple-50 transition-colors">
                        Advertising & Sponsorships
                    </a>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
