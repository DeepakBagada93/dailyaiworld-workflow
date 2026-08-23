@extends('layouts.editorial')

@section('title', 'Privacy Policy — Daily AI World')
@section('meta_description', 'Privacy Policy for Daily AI World. Learn about how we handle user data, cookies, third-party advertising partners including Google AdSense, analytics, and your privacy rights.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-[#6B7280] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5B21B6] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#5B21B6] font-semibold">Privacy Policy</span>
        </div>

        <div class="border-b border-[#E5E7EB] pb-8 mb-8">
            <div class="inline-flex items-center gap-2 bg-[#FAF5FF] border border-[#E9D5FF] text-[#5B21B6] px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-4">
                <span>LEGAL COMPLIANCE & TRANSPARENCY</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] tracking-tight">
                Privacy Policy
            </h1>
            <p class="mt-3 text-sm font-mono text-[#6B7280]">
                Last Updated: {{ date('F d, Y') }} · Effective Date: January 1, 2026
            </p>
        </div>

        <!-- Document Content -->
        <article class="prose prose-purple max-w-none text-[#374151] leading-relaxed space-y-8 font-sans">
            
            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">1. Introduction & Overview</h2>
                <p>
                    Welcome to <strong>Daily AI World</strong> (accessible at <a href="{{ url('/') }}" class="text-[#5B21B6] underline font-medium">{{ config('app.url', 'https://dailyaiworld.com') }}</a>), operated under the umbrella of <strong>SaaSNext</strong>. We are committed to protecting the privacy, security, and confidentiality of our visitors, readers, subscribers, and contributors.
                </p>
                <p>
                    This Privacy Policy details the types of personal and non-personal information we collect, how we store and process that data, and the steps we take to protect your privacy in compliance with applicable global privacy laws including the General Data Protection Regulation (GDPR) and the California Consumer Privacy Act (CCPA).
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">2. Information We Collect</h2>
                <p>When you visit and interact with Daily AI World, we may collect the following categories of information:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Log Files & Telemetry:</strong> Like most standard web servers, we automatically record server log files. These include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamps, referring/exit pages, and platform type to analyze trends and administer the site.</li>
                    <li><strong>Voluntary Submissions:</strong> Information you voluntarily provide when subscribing to our newsletter, submitting editorial contact requests, or interacting with interactive tools (e.g., your name, email address, and company affiliation).</li>
                    <li><strong>Cookies & Local Storage:</strong> We use essential session cookies, local storage preferences (such as light/dark theme preference and reading list bookmarks), and analytics cookies to enhance user experience.</li>
                </ul>
            </section>

            <section class="space-y-3 bg-[#FAF5FF] p-6 rounded-2xl border border-[#E9D5FF]">
                <h2 class="text-xl font-bold font-serif text-[#1E1B4B]">3. Google AdSense & Third-Party Advertising Disclosures</h2>
                <p class="text-sm text-[#4B5563]">
                    In compliance with Google advertising policies, we provide the following explicit disclosures regarding third-party vendors and ad serving:
                </p>
                <ul class="list-disc pl-6 space-y-2 text-sm text-[#374151]">
                    <li><strong>Google AdSense:</strong> Third-party vendors, including Google, use cookies to serve ads based on a user's prior visits to Daily AI World or other websites on the Internet.</li>
                    <li><strong>DoubleClick DART Cookie:</strong> Google's use of advertising cookies enables it and its partners to serve ads to our users based on their visit to our sites and/or other sites on the Internet.</li>
                    <li><strong>User Opt-Out:</strong> Users may opt out of personalized advertising by visiting <a href="https://adssettings.google.com/" target="_blank" rel="noopener noreferrer" class="text-[#5B21B6] font-semibold underline">Google Ads Settings</a>. Alternatively, you can opt out of a third-party vendor's use of cookies for personalized advertising by visiting <a href="https://www.aboutads.info/choices/" target="_blank" rel="noopener noreferrer" class="text-[#5B21B6] font-semibold underline">www.aboutads.info</a> or <a href="https://www.youronlinechoices.com/" target="_blank" rel="noopener noreferrer" class="text-[#5B21B6] font-semibold underline">Your Online Choices</a>.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">4. Web Analytics (Google Analytics GA4)</h2>
                <p>
                    We use Google Analytics (GA4) to analyze traffic patterns and audience engagement. Google Analytics collects aggregated, non-identifying telemetry about page visits, session duration, and geographical regions. Google Analytics does not log or store individual IP addresses. You can prevent Google Analytics from using your data by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer" class="text-[#5B21B6] underline">Google Analytics Opt-out Browser Add-on</a>.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">5. How We Use Collected Information</h2>
                <p>We use information collected on our website solely for legitimate editorial and operational purposes, including:</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Delivering technical AI dispatches, code snippets, and newsletter editions.</li>
                    <li>Improving site responsiveness, server performance, and user navigation.</li>
                    <li>Responding to editorial feedback, partnership inquiries, and technical support requests.</li>
                    <li>Preventing malicious traffic, security breaches, and fraudulent bot activities.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">6. Third-Party Links & External Code Repositories</h2>
                <p>
                    Daily AI World publishes technical dispatches containing external links to third-party services, GitHub repositories, Python package repositories (PyPI), npm packages, and official documentation (e.g., Anthropic, OpenAI, Qdrant, LangGraph). We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party websites or services.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">7. Your Data Protection Rights (GDPR & CCPA)</h2>
                <p>
                    Under European GDPR and California CCPA frameworks, you have the right to request access to any personal data we hold about you, request rectification or erasure of your personal data, restrict processing, or request data portability. To exercise any of these rights, please contact our Data Protection Officer at <a href="mailto:connect@saasnext.in" class="text-[#5B21B6] font-semibold underline">connect@saasnext.in</a>.
                </p>
            </section>

            <section class="space-y-3">
                <h2 class="text-xl font-bold font-serif text-[#111827]">8. Contact Information</h2>
                <p>
                    If you have any questions, concerns, or requests regarding this Privacy Policy, please contact us at:
                </p>
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 font-mono text-xs space-y-1 text-[#374151]">
                    <p class="font-bold text-[#111827] text-sm">Daily AI World / SaaSNext Editorial Team</p>
                    <p>Attn: Privacy & Compliance Officer (Deepak Bagada)</p>
                    <p>Email: <a href="mailto:connect@saasnext.in" class="text-[#5B21B6] underline">connect@saasnext.in</a></p>
                    <p>Website: <a href="https://dailyaiworld.com" class="text-[#5B21B6] underline">https://dailyaiworld.com</a></p>
                </div>
            </section>

        </article>
    </div>
</div>
@endsection
