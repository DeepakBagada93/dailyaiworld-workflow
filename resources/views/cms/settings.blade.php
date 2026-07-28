@extends('layouts.cms')

@section('title', 'System Settings — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto font-mono text-xs">
    <div class="border-b border-[#1F1F2E] pb-6">
        <span class="text-gray-400 font-bold uppercase">System Preferences</span>
        <h1 class="font-serif text-3xl font-extrabold text-white mt-1">Publication & CMS Settings</h1>
    </div>

    <div class="bg-[#14141E] border border-[#272738] rounded-xl p-6 space-y-6">
        <h3 class="font-serif text-lg font-bold text-white">General Publication Configuration</h3>

        <div class="space-y-4">
            <div>
                <label class="block text-gray-400 font-semibold mb-1">Publication Name</label>
                <input type="text" value="Daily AI World" class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3.5 py-2">
            </div>

            <div>
                <label class="block text-gray-400 font-semibold mb-1">Default Edition Title</label>
                <input type="text" value="The Journal of Artificial Intelligence & Compute Infrastructure" class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3.5 py-2">
            </div>

            <div>
                <label class="block text-gray-400 font-semibold mb-1">Newsletter Webhook Endpoint</label>
                <input type="text" value="https://api.dailyaiworld.com/v1/subscribers/sync" class="w-full bg-[#0E0E14] border border-[#272738] text-white rounded-md px-3.5 py-2">
            </div>
        </div>

        <div class="pt-4 border-t border-[#272738] flex justify-end">
            <button onclick="alert('Settings saved to database.')" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-5 py-2 rounded-md font-semibold">
                Save System Settings
            </button>
        </div>
    </div>
</div>
@endsection
