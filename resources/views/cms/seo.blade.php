@extends('layouts.cms')

@section('title', 'SEO & Schema — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-emerald-400 font-bold uppercase">Search & Indexing Engine</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">SEO & JSON-LD Schema Rules</h1>
    </div>

    <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-6">
        <h3 class="font-serif text-lg font-bold text-white">Global Meta Configuration</h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-400 font-semibold mb-1">Default OpenGraph Fallback Image</label>
                <input type="text" value="https://dailyaiworld.com/images/og-default.jpg" class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3.5 py-2">
            </div>

            <div>
                <label class="block text-gray-400 font-semibold mb-1">Publisher Organization Schema</label>
                <textarea rows="4" class="w-full bg-[#0E0E14] border border-[#272738] text-purple-300 rounded-md px-3.5 py-2">{
  "@context": "https://schema.org",
  "@type": "NewsMediaOrganization",
  "name": "Daily AI World",
  "publishingPrinciples": "https://dailyaiworld.com/design-system"
}</textarea>
            </div>
        </div>
    </div>
</div>
@endsection
