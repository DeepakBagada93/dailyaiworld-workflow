@extends('layouts.editorial')

@section('title', 'Terms of Service — Daily AI World')
@section('meta_description', 'Terms of Service for Daily AI World. Read our terms of use, intellectual property policies, open-source code usage guidelines, and liability disclosures.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-[#6B7280] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5B21B6] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#5B21B6] font-semibold">Terms of Service</span>
        </div>

        <div class="border-b border-[#E5E7EB] pb-8 mb-8">
            <div class="inline-flex items-center gap-2 bg-[#FAF5FF] border border-[#E9D5FF] text-[#5B21B6] px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-4">
                <span>TERMS & USAGE POLICIES</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] tracking-tight">
                Terms of Service
            </h1>
            <p class="mt-3 text-sm font-mono text-[#6B7280]">
                Last Updated: {{ date('F d, Y') }} · Effective Date: January 1, 2026
            </p>
        </div>

        <!-- Document Content -->
        <article class="prose prose-purple max-w-none text-[#374151] leading-relaxed space-y-8 font-sans">
            
            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">1. Acceptance of Terms</h2>
                <p>
                    By accessing or using <strong>Daily AI World</strong> (the "Service"), you agree to be bound by these Terms of Service ("Terms"). If you disagree with any part of these terms, you may not access the Service.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">2. Intellectual Property & Open-Source Code</h2>
                <p>
                    All editorial articles, technical analysis, benchmarks, research papers, diagrams, and written dispatches published on Daily AI World are the copyrighted intellectual property of Daily AI World and SaaSNext, unless otherwise specified.
                </p>
                <p>
                    <strong>Executable Code Samples & MCP Tool Implementations:</strong> Technical code snippets and runnable implementations included within our dispatches are provided for educational and architectural reference. You are permitted to use, modify, and integrate these patterns into your internal or open-source software with appropriate attribution.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">3. Permitted & Acceptable Use</h2>
                <p>You agree not to use Daily AI World to:</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Engage in unauthorized automated scraping, scraping at rates that overwhelm server infrastructure, or denial-of-service attempts.</li>
                    <li>Attempt to bypass security headers, authentication endpoints, or rate limiters.</li>
                    <li>Misrepresent affiliation with Daily AI World, SaaSNext, or our editorial team.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">4. Disclaimer of Warranties</h2>
                <p>
                    Daily AI World is provided on an "AS IS" and "AS AVAILABLE" basis. While our engineering team rigorously tests architectural blueprints, code snippets, and benchmark dispatches, we make no representations or warranties of any kind, express or implied, regarding system uptime, algorithmic output correctness, or suitability for enterprise production workloads without your independent verification.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">5. Limitation of Liability</h2>
                <p>
                    In no event shall Daily AI World, SaaSNext, its founders, directors, employees, or contributors be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your access to or inability to access our dispatches or implement our published architectural workflows.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">6. Changes to Terms</h2>
                <p>
                    We reserve the right, at our sole discretion, to modify or replace these Terms at any time. Changes become effective immediately upon being posted on this page.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">7. Contact</h2>
                <p>
                    For inquiries regarding these Terms of Service, please contact <a href="mailto:connect@saasnext.in" class="text-[#5B21B6] font-semibold underline">connect@saasnext.in</a>.
                </p>
            </section>

        </article>
    </div>
</div>
@endsection
