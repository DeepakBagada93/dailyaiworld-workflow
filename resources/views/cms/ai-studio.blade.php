@extends('layouts.cms')

@section('title', 'AI Content Studio — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-[#8B5CF6] font-bold uppercase">Automated Research Assistant</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">AI Content Studio & Prompt Library</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{ prompt: '', output: '' }">
        <!-- Left: Prompt Selection & Generator -->
        <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4">
            <h3 class="font-serif text-lg font-bold text-white">Editorial Prompt Presets</h3>

            <div class="space-y-2">
                <button @click="prompt = 'Generate executive summary and key takeaways for a technical paper on Mixture of Experts (MoE) routing collapse.'" class="w-full text-left p-3 rounded bg-[#161622] hover:bg-[#1E1B2E] text-gray-300 hover:text-white border border-[#272738] transition-colors">
                    <span class="font-bold text-[#8B5CF6] block">1. Paper Breakdown</span>
                    <span class="text-[11px] text-gray-500">Extracts key takeaways & JSON-LD FAQs</span>
                </button>

                <button @click="prompt = 'Draft a founder interview outline for an AI-native SaaS company generating $2M ARR per employee.'" class="w-full text-left p-3 rounded bg-[#161622] hover:bg-[#1E1B2E] text-gray-300 hover:text-white border border-[#272738] transition-colors">
                    <span class="font-bold text-blue-400 block">2. Founder Interview</span>
                    <span class="text-[11px] text-gray-500">Generates unit economics questions</span>
                </button>

                <button @click="prompt = 'Analyze GPU cloud spot rates and generate market index summary commentary.'" class="w-full text-left p-3 rounded bg-[#161622] hover:bg-[#1E1B2E] text-gray-300 hover:text-white border border-[#272738] transition-colors">
                    <span class="font-bold text-emerald-400 block">3. Compute Ticker Analysis</span>
                    <span class="text-[11px] text-gray-500">H100 & B200 spot price trends</span>
                </button>
            </div>
        </div>

        <!-- Right 2 cols: AI Studio Output Canvas -->
        <div class="md:col-span-2 bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-[#272738] pb-3">
                    <h3 class="font-serif text-lg font-bold text-white">AI Studio Output Canvas</h3>
                    <button @click="output = '## AI Executive Summary\n\n- Test-time search allows 14B models to outpace 70B static weights.\n- HBM3e bandwidth is the primary hardware bottleneck for 2026 enterprise clusters.\n- Enterprise billing is shifting from prompt tokens to verified solutions.';" class="px-3 py-1 bg-[#8B5CF6] text-white rounded font-semibold">Generate Output</button>
                </div>

                <textarea x-model="prompt" rows="3" placeholder="Enter custom prompt instructions for the AI editorial assistant..." class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md p-3 focus:outline-none focus:border-[#8B5CF6]"></textarea>

                <div class="p-4 bg-[#0E0E14] border border-[#272738] rounded-md text-gray-300 min-h-[160px] whitespace-pre-wrap" x-text="output || 'AI output will appear here after clicking generate...'"></div>
            </div>
        </div>
    </div>
</div>
@endsection
