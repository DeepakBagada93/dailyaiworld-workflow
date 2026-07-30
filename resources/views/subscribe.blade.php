@extends('layouts.editorial')

@section('title', 'Daily AI World Executive Tier — Premium Intelligence')
@section('meta_description', 'Unlock unlimited deep-dive AI research digests, executive audio briefings, Notion architecture templates, and direct access.')

@section('content')
<div class="min-h-screen bg-[#FFFFFF] text-[#111111] antialiased">

    <!-- Header Section -->
    <section class="border-b border-gray-200 bg-[#FAF9F6] py-16 px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-black text-white px-3.5 py-1 rounded-full text-xs font-mono font-semibold mb-6">
                <span>DAILY AI WORLD EXECUTIVE MEMBERSHIP</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                Independent AI Intelligence for Builders & Decision Makers
            </h1>

            <p class="mt-6 text-lg text-gray-600 font-sans max-w-2xl mx-auto leading-relaxed">
                Join founders, CTOs, and AI engineers at OpenAI, Stripe, Vercel, and GitHub receiving non-sensational, battle-tested AI architecture breakdowns.
            </p>
        </div>
    </section>

    <!-- Pricing Toggle & Cards -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto" x-data="{ billingCycle: 'annual' }">

        <!-- Billing Selector -->
        <div class="flex items-center justify-center gap-4 mb-12">
            <span class="text-sm font-medium text-gray-600" :class="{ 'text-gray-900 font-bold': billingCycle === 'monthly' }">Monthly Billing</span>
            
            <button @click="billingCycle = billingCycle === 'monthly' ? 'annual' : 'monthly'" 
                    class="w-14 h-8 bg-gray-900 rounded-full p-1 transition-colors relative focus:outline-none">
                <div class="w-6 h-6 bg-white rounded-full transition-transform"
                     :class="{ 'translate-x-6': billingCycle === 'annual' }"></div>
            </button>

            <span class="text-sm font-medium text-gray-600 flex items-center gap-2" :class="{ 'text-gray-900 font-bold': billingCycle === 'annual' }">
                <span>Annual Billing</span>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-mono font-bold px-2 py-0.5 rounded-full">Save 17%</span>
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- Free Tier Card -->
            <div class="border border-gray-200 rounded-2xl p-8 bg-white flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-gray-400 font-bold block mb-2">Standard Reader</span>
                    <h3 class="font-serif text-2xl font-bold text-gray-900">Public Journal</h3>
                    <p class="mt-2 text-sm text-gray-600 font-sans">Essential coverage of breaking AI developments and public news dispatches.</p>

                    <div class="mt-6 border-t border-gray-100 pt-6 font-mono">
                        <span class="text-4xl font-extrabold text-gray-900">$0</span>
                        <span class="text-xs text-gray-500">/ forever</span>
                    </div>

                    <ul class="mt-8 space-y-4 text-sm text-gray-600 font-sans">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Access to daily public news dispatches</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Standard RSS feed subscription</span>
                        </li>
                        <li class="flex items-center gap-3 opacity-40">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="line-through">Deep-dive architecture breakdowns</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('home') }}" class="mt-8 block text-center border border-gray-300 hover:border-gray-900 text-gray-800 font-semibold py-3 rounded-lg text-sm transition-colors">
                    Continue Free
                </a>
            </div>

            <!-- Executive Tier Card -->
            <div class="border-2 border-purple-600 rounded-2xl p-8 bg-white shadow-xl flex flex-col justify-between relative">
                <div class="absolute -top-3.5 right-6 bg-purple-600 text-white text-[10px] font-mono uppercase tracking-widest font-bold px-3.5 py-1 rounded-full">
                    Recommended Executive Tier
                </div>

                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-purple-600 font-bold block mb-2">FULL ACCESS PASS</span>
                    <h3 class="font-serif text-2xl font-bold text-gray-900">Executive Subscriber</h3>
                    <p class="mt-2 text-sm text-gray-600 font-sans">Full access to deep-dive architecture specs, AI code repos, research digests, and executive briefings.</p>

                    <div class="mt-6 border-t border-gray-100 pt-6 font-mono">
                        <div x-show="billingCycle === 'annual'">
                            <span class="text-4xl font-extrabold text-purple-600">$190</span>
                            <span class="text-xs text-gray-500">/ year ($15.83/mo)</span>
                        </div>
                        <div x-show="billingCycle === 'monthly'">
                            <span class="text-4xl font-extrabold text-purple-600">$19</span>
                            <span class="text-xs text-gray-500">/ month</span>
                        </div>
                    </div>

                    <ul class="mt-8 space-y-4 text-sm text-gray-700 font-sans">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Unlimited Access</strong> to all paywalled deep dives</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Executive Audio Briefings</strong> for every article</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Downloadable Notion & GitHub</strong> code templates</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Direct Q&A access with <a href="https://deepakbagada.in/" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-purple-600 underline">Deepak Bagada</a> (CEO, <a href="https://saasnext.in/" target="_blank" rel="noopener noreferrer" class="font-bold hover:text-purple-600 underline">SaaSNext</a>)</span>
                        </li>
                    </ul>
                </div>

                <form action="{{ route('subscribe.checkout') }}" method="POST" class="mt-8">
                    @csrf
                    <input type="hidden" name="plan" :value="billingCycle">
                    <input type="hidden" name="email" value="{{ auth()->user()?->email ?? 'subscriber@dailyaiworld.com' }}">
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 rounded-lg text-sm transition-all shadow-md">
                        Activate Executive Membership →
                    </button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
