@extends('layouts.editorial')

@section('title', 'Contact Us — Daily AI World')
@section('meta_description', 'Contact the editorial desk and technical review board at Daily AI World. Reach out for editorial inquiries, corrections, technical contributions, and partnerships.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased font-sans py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-[#6B7280] mb-6">
            <a href="{{ route('home') }}" class="hover:text-[#5B21B6] transition-colors">Home</a>
            <span>/</span>
            <span class="text-[#5B21B6] font-semibold">Contact Us</span>
        </div>

        <div class="border-b border-[#E5E7EB] pb-8 mb-10">
            <div class="inline-flex items-center gap-2 bg-[#FAF5FF] border border-[#E9D5FF] text-[#5B21B6] px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-4">
                <span>COMMUNICATIONS & EDITORIAL DESK</span>
            </div>
            <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#111827] tracking-tight">
                Get in Touch
            </h1>
            <p class="mt-3 text-lg text-[#4B5563]">
                Have a technical question, code contribution, editorial correction, or brand inquiry? We’d love to hear from you.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Info Panel -->
            <div class="space-y-6">
                <div class="bg-[#FAF5FF] border border-[#E9D5FF] rounded-2xl p-6 space-y-4">
                    <h2 class="text-base font-bold font-serif text-[#1E1B4B]">Direct Channels</h2>
                    
                    <div class="space-y-3 text-xs font-mono">
                        <div>
                            <span class="text-[#6B7280] block uppercase tracking-wider text-[10px]">General & Partnerships</span>
                            <a href="mailto:connect@saasnext.in" class="text-[#5B21B6] font-bold text-sm hover:underline block mt-0.5">connect@saasnext.in</a>
                        </div>

                        <div class="pt-2 border-t border-purple-100">
                            <span class="text-[#6B7280] block uppercase tracking-wider text-[10px]">Founder & Editor</span>
                            <span class="text-[#111827] font-semibold block mt-0.5 font-sans">Deepak Bagada</span>
                            <a href="https://x.com/deeepakbagada" target="_blank" rel="noopener noreferrer" class="text-[#5B21B6] hover:underline">@deeepakbagada on X ↗</a>
                        </div>

                        <div class="pt-2 border-t border-purple-100">
                            <span class="text-[#6B7280] block uppercase tracking-wider text-[10px]">Response SLA</span>
                            <span class="text-[#111827] font-sans">Within 24 to 48 business hours</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-[#E5E7EB] rounded-2xl p-6 text-xs text-[#4B5563] space-y-2">
                    <h3 class="font-bold text-[#111827] font-serif text-sm">Editorial Corrections</h3>
                    <p class="leading-relaxed">
                        If you spot an algorithmic inaccuracy, outdated dependency version, or broken code reference in any dispatch, please include the article URL and proposed errata.
                    </p>
                </div>
            </div>

            <!-- Right Contact Form -->
            <div class="md:col-span-2 bg-white border border-[#E5E7EB] rounded-2xl p-6 sm:p-8 shadow-xs">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm space-y-1">
                        <span class="font-bold block">Please resolve the following errors:</span>
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-mono font-bold uppercase tracking-wider text-[#374151] mb-1.5">
                            Your Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#5B21B6] focus:border-[#5B21B6] outline-none transition-all placeholder-gray-400"
                               placeholder="e.g. Alex Turing">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-mono font-bold uppercase tracking-wider text-[#374151] mb-1.5">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#5B21B6] focus:border-[#5B21B6] outline-none transition-all placeholder-gray-400"
                               placeholder="alex@example.com">
                    </div>

                    <div>
                        <label for="subject" class="block text-xs font-mono font-bold uppercase tracking-wider text-[#374151] mb-1.5">
                            Subject / Topic <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#5B21B6] focus:border-[#5B21B6] outline-none transition-all placeholder-gray-400"
                               placeholder="e.g., Code Clarification in FastMCP Dispatch">
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-mono font-bold uppercase tracking-wider text-[#374151] mb-1.5">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#5B21B6] focus:border-[#5B21B6] outline-none transition-all placeholder-gray-400 leading-relaxed"
                                  placeholder="Write your inquiry or feedback here...">{{ old('message') }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#5B21B6] text-white rounded-xl font-bold text-sm hover:bg-[#4C1D95] shadow-sm hover:shadow-md transition-all">
                            Send Message →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
