@extends('layouts.editorial')

@section('title', 'Global Design System & Token Specifications — Daily AI World')

@section('content')
<div class="future-newsroom newsroom-page max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">
    
    <!-- Hero Header -->
    <header class="border-b border-[var(--border-subtle)] pb-10">
        <div class="flex items-center gap-2 font-mono text-xs text-[#6D28D9] font-bold uppercase tracking-widest mb-2">
            <span>Engineering & Design Specs</span>
            <span>•</span>
            <span>Design Tokens 1.0</span>
        </div>
        <h1 class="font-serif text-4xl sm:text-5xl font-extrabold text-[var(--text-heading)]">
            Design System & Foundation Architecture
        </h1>
        <p class="text-base sm:text-lg text-[var(--text-body)] mt-4 max-w-3xl leading-relaxed">
            The authoritative design manual for Daily AI World. Inspired by Forbes, Bloomberg, Stripe Press, and Apple Newsroom. Built for extreme legibility, zero visual clutter, and timeless editorial elegance.
        </p>
    </header>

    <!-- SECTION 1: COLOR SYSTEM & TOKENS -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">1. Color Palette Tokens</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Core brand colors, surfaces, and functional states</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 font-mono text-xs">
            <!-- Primary -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#6D28D9] text-white">
                <div class="font-bold text-sm">Primary</div>
                <div class="opacity-90 mt-1">#6D28D9</div>
                <div class="text-[10px] mt-4 opacity-75">Brand Accent</div>
            </div>

            <!-- Primary Hover -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#7C3AED] text-white">
                <div class="font-bold text-sm">Primary Hover</div>
                <div class="opacity-90 mt-1">#7C3AED</div>
                <div class="text-[10px] mt-4 opacity-75">Hover State</div>
            </div>

            <!-- Accent -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#8B5CF6] text-white">
                <div class="font-bold text-sm">Accent</div>
                <div class="opacity-90 mt-1">#8B5CF6</div>
                <div class="text-[10px] mt-4 opacity-75">Highlights</div>
            </div>

            <!-- Background -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-white text-gray-900">
                <div class="font-bold text-sm">Background</div>
                <div class="text-gray-600 mt-1">#FFFFFF</div>
                <div class="text-[10px] mt-4 text-gray-500">Surface 0</div>
            </div>

            <!-- Secondary BG -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#FAFAFC] text-gray-900">
                <div class="font-bold text-sm">Secondary BG</div>
                <div class="text-gray-600 mt-1">#FAFAFC</div>
                <div class="text-[10px] mt-4 text-gray-500">Surface 1</div>
            </div>

            <!-- Muted Surface -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#F5F3FF] text-[#6D28D9]">
                <div class="font-bold text-sm">Muted Surface</div>
                <div class="opacity-90 mt-1">#F5F3FF</div>
                <div class="text-[10px] mt-4 opacity-75">Highlights</div>
            </div>

            <!-- Border -->
            <div class="p-4 rounded-xl border-2 border-[#E8E7EF] bg-[var(--bg-card)] text-[var(--text-heading)]">
                <div class="font-bold text-sm">Border</div>
                <div class="text-[var(--text-muted)] mt-1">#E8E7EF</div>
                <div class="text-[10px] mt-4 text-[var(--text-muted)]">Subtle Dividers</div>
            </div>

            <!-- Heading -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#111827] text-white">
                <div class="font-bold text-sm">Heading</div>
                <div class="opacity-90 mt-1">#111827</div>
                <div class="text-[10px] mt-4 opacity-75">Playfair Titles</div>
            </div>

            <!-- Body -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#4B5563] text-white">
                <div class="font-bold text-sm">Body Text</div>
                <div class="opacity-90 mt-1">#4B5563</div>
                <div class="text-[10px] mt-4 opacity-75">Inter Body</div>
            </div>

            <!-- Muted -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#9CA3AF] text-white">
                <div class="font-bold text-sm">Muted</div>
                <div class="opacity-90 mt-1">#9CA3AF</div>
                <div class="text-[10px] mt-4 opacity-75">Captions/Dates</div>
            </div>

            <!-- Success -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#22C55E] text-white">
                <div class="font-bold text-sm">Success</div>
                <div class="opacity-90 mt-1">#22C55E</div>
                <div class="text-[10px] mt-4 opacity-75">Positive Ticker</div>
            </div>

            <!-- Warning -->
            <div class="p-4 rounded-xl border border-[var(--border-subtle)] bg-[#F59E0B] text-white">
                <div class="font-bold text-sm">Warning</div>
                <div class="opacity-90 mt-1">#F59E0B</div>
                <div class="text-[10px] mt-4 opacity-75">Alerts</div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: TYPOGRAPHY SCALE -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">2. Typography Scale</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Headings (Playfair Display), Body (Inter), Code (JetBrains Mono)</p>
        </div>

        <div class="space-y-6 bg-[var(--bg-sec)] border border-[var(--border-subtle)] rounded-xl p-8">
            <div class="border-b border-[var(--border-subtle)] pb-4">
                <span class="font-mono text-xs text-[#6D28D9]">Display 6XL — Playfair Display Extrabold</span>
                <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-extrabold text-[var(--text-heading)] mt-1">
                    The Future of Intelligence
                </h1>
            </div>

            <div class="border-b border-[var(--border-subtle)] pb-4">
                <span class="font-mono text-xs text-[#6D28D9]">Heading 3XL — Playfair Display Bold</span>
                <h2 class="font-serif text-3xl font-bold text-[var(--text-heading)] mt-1">
                    Silicon Supply Chains & Frontier Compute
                </h2>
            </div>

            <div class="border-b border-[var(--border-subtle)] pb-4">
                <span class="font-mono text-xs text-[#6D28D9]">Body Lead — Inter Regular (18px / 1.8 line height)</span>
                <p class="text-lg text-[var(--text-body)] mt-1 leading-relaxed">
                    As brute-force pre-training scaling laws approach physical limits, labs are pivoting to test-time search.
                </p>
            </div>

            <div>
                <span class="font-mono text-xs text-[#6D28D9]">Code & Metrics — JetBrains Mono (14px)</span>
                <div class="mt-2 p-4 bg-slate-900 text-purple-300 font-mono text-sm rounded-lg">
                    const AgentCluster = new Swarm({ reasoning: 'test-time-search', computeBudget: '500GFLOPS' });
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: BUTTONS & INTERACTION STATES -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">3. UI Component Library — Buttons</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Primary, Secondary, Outline, and Icon variants</p>
        </div>

        <div class="flex flex-wrap items-center gap-6 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8">
            <div>
                <button class="btn-primary">
                    <span>Primary Action</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
                <span class="block text-[10px] font-mono text-[var(--text-muted)] mt-2">.btn-primary (#6D28D9)</span>
            </div>

            <div>
                <button class="btn-secondary">
                    <svg class="w-4 h-4 text-[#6D28D9]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                    <span>Secondary Action</span>
                </button>
                <span class="block text-[10px] font-mono text-[var(--text-muted)] mt-2">.btn-secondary (#F5F3FF)</span>
            </div>

            <div>
                <button class="btn-outline">
                    <span>Outline Button</span>
                </button>
                <span class="block text-[10px] font-mono text-[var(--text-muted)] mt-2">.btn-outline</span>
            </div>
        </div>
    </section>

    <!-- SECTION 4: BADGES & CATEGORIES -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">4. Tier & Category Badges</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Standard editorial classification tags</p>
        </div>

        <div class="flex flex-wrap items-center gap-4 bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8">
            <x-badge tier="Breaking" />
            <x-badge tier="Deep Dive" />
            <x-badge tier="Founder Story" />
            <x-badge tier="Research Breakdown" />
            <x-badge tier="Briefing" />
        </div>
    </section>

    <!-- SECTION 5: SKELETON LOADING STATES -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">5. Loading Skeleton Preview</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Placeholders for asynchronous content fetching</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-skeleton type="card" />
            <x-skeleton type="card" />
            <x-skeleton type="card" />
        </div>
    </section>

    <!-- SECTION 6: FORM INPUTS & NEWSLETTER -->
    <section class="space-y-6">
        <div class="border-b border-[var(--border-subtle)] pb-3">
            <h2 class="font-serif text-2xl font-bold text-[var(--text-heading)]">6. Inputs & Controls</h2>
            <p class="text-xs text-[var(--text-muted)] font-mono">Accessible input fields and interactive states</p>
        </div>

        <div class="max-w-xl bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8 space-y-4">
            <div>
                <label class="block text-xs font-mono uppercase font-bold text-[var(--text-heading)] mb-2">Work Email Address</label>
                <input type="email" placeholder="executive@company.com" 
                       class="w-full bg-[var(--bg-sec)] border border-[var(--border-subtle)] text-[var(--text-heading)] placeholder-[var(--text-muted)] text-sm rounded-md px-4 py-3 focus:outline-none focus:border-[#6D28D9]">
            </div>
        </div>
    </section>

</div>
@endsection
