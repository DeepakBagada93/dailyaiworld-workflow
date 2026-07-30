@extends('layouts.editorial')

@section('title', 'Sponsor & Partner Dispatches — Daily AI World')
@section('meta_description', 'Partner with Daily AI World to reach 50,000+ AI founders, ML engineers, SaaS builders, and enterprise tech executives.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased">

    <!-- Hero Sponsor Banner -->
    <section class="border-b border-gray-200 bg-[#FAF9F6] py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-purple-50 border border-purple-200 px-3.5 py-1 rounded-full text-xs font-mono font-semibold text-purple-700 mb-6">
                <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                <span>Q3/Q4 2026 Editorial Sponsorship Inventory Open</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-extrabold text-[#111111] tracking-tight leading-tight max-w-4xl mx-auto">
                Reach the Engineers & Executives Building the AI Future.
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-gray-600 font-sans max-w-2xl mx-auto leading-relaxed">
                Daily AI World reaches over <strong class="text-gray-900 font-semibold">42,000+ verified AI founders, developers, and enterprise decision-makers</strong> every morning.
            </p>

            <!-- Key Audience Metrics -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6 font-mono text-left max-w-4xl mx-auto">
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-xs text-gray-500 uppercase tracking-wider block">Monthly Readers</span>
                    <span class="font-serif text-3xl font-extrabold text-gray-900 mt-1 block">42,500+</span>
                    <span class="text-[11px] text-emerald-600 font-sans mt-1 block">↑ 28.5% MoM Growth</span>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-xs text-gray-500 uppercase tracking-wider block">Avg Email CTR</span>
                    <span class="font-serif text-3xl font-extrabold text-purple-600 mt-1 block">9.12%</span>
                    <span class="text-[11px] text-gray-500 font-sans mt-1 block">3x Industry Benchmark</span>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-xs text-gray-500 uppercase tracking-wider block">Executive Audience</span>
                    <span class="font-serif text-3xl font-extrabold text-gray-900 mt-1 block">68%</span>
                    <span class="text-[11px] text-gray-500 font-sans mt-1 block">Founders, CTOs, Tech Leads</span>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <span class="text-xs text-gray-500 uppercase tracking-wider block">Production Posts</span>
                    <span class="font-serif text-3xl font-extrabold text-gray-900 mt-1 block">804+</span>
                    <span class="text-[11px] text-gray-500 font-sans mt-1 block">High-Intent Organic Search</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted Partners Logo Rail -->
    <section class="py-10 border-b border-gray-200 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <span class="text-xs font-mono uppercase tracking-widest text-gray-400 font-bold block mb-6">
                Trusted by Leading AI Infrastructure & Tooling Companies
            </span>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-12 opacity-80">
                <span class="font-mono text-xl font-bold tracking-tight text-gray-800">ANTHROPIC</span>
                <span class="font-mono text-xl font-bold tracking-tight text-gray-800">PINECONE</span>
                <span class="font-mono text-xl font-bold tracking-tight text-gray-800">FIREWORKS.AI</span>
                <span class="font-mono text-xl font-bold tracking-tight text-gray-800">LANGCHAIN</span>
                <span class="font-mono text-xl font-bold tracking-tight text-gray-800">SCALE AI</span>
            </div>
        </div>
    </section>

    <!-- Sponsorship Options & Rate Card -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="font-serif text-3xl font-bold text-gray-900">Sponsorship Packages & Rate Card</h2>
            <p class="mt-3 text-gray-600 font-sans">High-impact, low-clutter placements designed to preserve editorial trust while driving high-intent conversions.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Package 1: Executive Newsletter Briefing -->
            <div class="border border-gray-200 rounded-2xl p-8 bg-white shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                <div>
                    <div class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-mono font-semibold mb-4">
                        Most Popular
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-gray-900">Executive Newsletter</h3>
                    <p class="mt-2 text-sm text-gray-600">Exclusive primary sponsorship slot at the top of our daily morning dispatch sent to 42,000+ readers.</p>
                    
                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <div class="font-mono">
                            <span class="text-3xl font-extrabold text-gray-900">$4,500</span>
                            <span class="text-xs text-gray-500">/ month (4 issues)</span>
                        </div>
                        <ul class="mt-6 space-y-3 text-sm text-gray-600 font-sans">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Logo + 150-word native dispatch</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Tracked CTA button & dedicated URL</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Guaranteed 3,500+ click minimum</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="#inquiry-form" class="mt-8 block text-center bg-black hover:bg-gray-800 text-white font-medium py-3 rounded-lg text-sm transition-colors">
                    Reserve Newsletter Slot
                </a>
            </div>

            <!-- Package 2: Dedicated Sponsored Dispatch -->
            <div class="border-2 border-purple-600 rounded-2xl p-8 bg-white shadow-lg flex flex-col justify-between relative">
                <div class="absolute -top-3 right-6 bg-purple-600 text-white text-[10px] font-mono uppercase tracking-widest font-bold px-3 py-1 rounded-full">
                    High Conversion
                </div>
                <div>
                    <div class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-mono font-semibold mb-4">
                        Editorial Article
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-gray-900">Sponsored Dispatch</h3>
                    <p class="mt-2 text-sm text-gray-600">Full co-authored deep dive published on Daily AI World home page and distributed across all RSS feeds.</p>
                    
                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <div class="font-mono">
                            <span class="text-3xl font-extrabold text-purple-600">$3,200</span>
                            <span class="text-xs text-gray-500">/ dispatch</span>
                        </div>
                        <ul class="mt-6 space-y-3 text-sm text-gray-600 font-sans">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>1,500+ word editorial feature story</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Permanent indexed web archive</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Social distribution on LinkedIn & X</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="#inquiry-form" class="mt-8 block text-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-lg text-sm transition-colors">
                    Commission Dispatch
                </a>
            </div>

            <!-- Package 3: Category Desk Partner Rail -->
            <div class="border border-gray-200 rounded-2xl p-8 bg-white shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                <div>
                    <div class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-mono font-semibold mb-4">
                        Brand Awareness
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-gray-900">Desk Partner Rail</h3>
                    <p class="mt-2 text-sm text-gray-600">Exclusive sidebar sponsorship on specific editorial desks like AI Workflows, Coding, or RAG.</p>
                    
                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <div class="font-mono">
                            <span class="text-3xl font-extrabold text-gray-900">$2,800</span>
                            <span class="text-xs text-gray-500">/ month</span>
                        </div>
                        <ul class="mt-6 space-y-3 text-sm text-gray-600 font-sans">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Sticky banner across desk archives</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>100% share of voice on target category</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Monthly analytics report</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="#inquiry-form" class="mt-8 block text-center bg-black hover:bg-gray-800 text-white font-medium py-3 rounded-lg text-sm transition-colors">
                    Sponsor Category Desk
                </a>
            </div>
        </div>
    </section>

    <!-- Sponsor Lead Inquiry Form -->
    <section id="inquiry-form" class="py-16 bg-[#FAF9F6] border-t border-gray-200 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-2xl p-8 shadow-md">

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg font-sans text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="font-serif text-2xl font-bold text-gray-900 text-center">Request Media Kit & Book Placements</h3>
            <p class="text-sm text-gray-600 text-center mt-2 font-sans mb-8">Fill out the brief form below and our editorial director will respond within 24 hours.</p>

            <form action="{{ route('advertise.lead') }}" method="POST" class="space-y-5 font-sans">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-mono font-semibold text-gray-700 uppercase mb-2">Your Full Name</label>
                        <input type="text" name="name" required placeholder="Deepak Bagada" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-mono font-semibold text-gray-700 uppercase mb-2">Company / Product</label>
                        <input type="text" name="company" required placeholder="Anthropic, Pinecone, etc." class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-mono font-semibold text-gray-700 uppercase mb-2">Work Email</label>
                        <input type="email" name="email" required placeholder="you@company.com" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-mono font-semibold text-gray-700 uppercase mb-2">Placement Interest</label>
                        <select name="placement_interest" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm bg-white">
                            <option value="Executive Newsletter ($4,500/mo)">Executive Newsletter ($4,500/mo)</option>
                            <option value="Sponsored Dispatch ($3,200)">Sponsored Dispatch ($3,200)</option>
                            <option value="Desk Partner Rail ($2,800/mo)">Desk Partner Rail ($2,800/mo)</option>
                            <option value="Custom Multi-Channel Campaign">Custom Multi-Channel Campaign</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-gray-700 uppercase mb-2">Campaign Goals & Notes</label>
                    <textarea name="message" rows="4" placeholder="Tell us about your product target audience and campaign timeline..." class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm"></textarea>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-lg text-sm transition-all shadow-md">
                    Submit Sponsorship Inquiry →
                </button>
            </form>
        </div>
    </section>

</div>
@endsection
