@extends('layouts.cms')

@section('title', 'Sponsor CRM & Campaigns — Daily AI World Enterprise CMS')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto" x-data="{ addSponsorOpen: false }">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#1F1F2E] pb-6">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-purple-400 mb-1">
                <span>Revenue CRM</span>
                <span>•</span>
                <span>Partner & Sponsor Roster</span>
            </div>
            <h1 class="font-serif text-3xl font-extrabold text-white">Sponsor CRM & Campaign Management</h1>
        </div>

        <div class="flex items-center gap-3">
            <button @click="addSponsorOpen = true" class="bg-[#8B5CF6] hover:bg-[#7C3AED] text-white px-4 py-2 rounded-md text-xs font-semibold flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add Sponsor Company</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-900/40 border border-emerald-700/60 text-emerald-300 rounded-lg text-xs font-mono">
            {{ session('success') }}
        </div>
    @endif

    <!-- Sponsor Roster Table -->
    <div class="bg-[#14141E] border border-[#272738] rounded-xl overflow-hidden shadow-xl font-mono text-xs">
        <div class="px-6 py-4 border-b border-[#272738] flex items-center justify-between">
            <h3 class="font-serif text-base font-bold text-white">Sponsor Companies & Placements</h3>
            <span class="text-gray-400 text-[11px]">{{ $sponsors->count() }} Total Records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1B1B2A] text-gray-400 uppercase text-[10px] tracking-wider border-b border-[#272738]">
                        <th class="py-3 px-6">Sponsor Company</th>
                        <th class="py-3 px-6">Contact Email</th>
                        <th class="py-3 px-6">Website URL</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Placements</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F1F2E] text-gray-300">
                    @forelse($sponsors as $sponsor)
                        <tr class="hover:bg-[#1A1A28] transition-colors">
                            <td class="py-4 px-6 font-bold text-white font-serif text-sm">
                                {{ $sponsor->name }}
                            </td>
                            <td class="py-4 px-6 text-gray-300">
                                {{ $sponsor->contact_email }}
                            </td>
                            <td class="py-4 px-6 text-sky-400 underline">
                                <a href="{{ $sponsor->website_url }}" target="_blank">{{ $sponsor->website_url }}</a>
                            </td>
                            <td class="py-4 px-6">
                                @if($sponsor->status === 'active')
                                    <span class="bg-emerald-900/60 text-emerald-300 px-2.5 py-1 rounded-full text-[10px] font-bold border border-emerald-700/50">ACTIVE</span>
                                @elseif($sponsor->status === 'prospect')
                                    <span class="bg-amber-900/60 text-amber-300 px-2.5 py-1 rounded-full text-[10px] font-bold border border-amber-700/50">PROSPECT</span>
                                @else
                                    <span class="bg-gray-800 text-gray-400 px-2.5 py-1 rounded-full text-[10px] font-bold">INACTIVE</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-purple-400">
                                {{ $sponsor->sponsorships->count() }} Campaigns
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No sponsors registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Sponsor Modal -->
    <div x-show="addSponsorOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-[#14141E] border border-[#272738] rounded-xl max-w-lg w-full p-6 shadow-2xl space-y-4 font-mono text-xs">
            <div class="flex items-center justify-between border-b border-[#272738] pb-3">
                <h3 class="font-serif text-lg font-bold text-white">Add New Sponsor Company</h3>
                <button @click="addSponsorOpen = false" class="text-gray-400 hover:text-white">✕</button>
            </div>

            <form action="{{ route('cms.sponsors.create') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-400 uppercase text-[10px] mb-1">Company Name</label>
                    <input type="text" name="name" required class="w-full bg-[#1B1B2A] border border-[#2A2A3E] text-white p-2.5 rounded text-xs focus:outline-none focus:border-[#8B5CF6]">
                </div>

                <div>
                    <label class="block text-gray-400 uppercase text-[10px] mb-1">Website URL</label>
                    <input type="url" name="website_url" required placeholder="https://..." class="w-full bg-[#1B1B2A] border border-[#2A2A3E] text-white p-2.5 rounded text-xs focus:outline-none focus:border-[#8B5CF6]">
                </div>

                <div>
                    <label class="block text-gray-400 uppercase text-[10px] mb-1">Contact Email</label>
                    <input type="email" name="contact_email" required placeholder="partner@company.com" class="w-full bg-[#1B1B2A] border border-[#2A2A3E] text-white p-2.5 rounded text-xs focus:outline-none focus:border-[#8B5CF6]">
                </div>

                <div>
                    <label class="block text-gray-400 uppercase text-[10px] mb-1">Status</label>
                    <select name="status" class="w-full bg-[#1B1B2A] border border-[#2A2A3E] text-white p-2.5 rounded text-xs focus:outline-none focus:border-[#8B5CF6]">
                        <option value="active">Active</option>
                        <option value="prospect">Prospect / Lead</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-400 uppercase text-[10px] mb-1">Internal Notes</label>
                    <textarea name="notes" rows="3" class="w-full bg-[#1B1B2A] border border-[#2A2A3E] text-white p-2.5 rounded text-xs focus:outline-none focus:border-[#8B5CF6]"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="addSponsorOpen = false" class="px-4 py-2 bg-gray-800 text-gray-300 rounded text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#8B5CF6] hover:bg-[#7C3AED] text-white rounded text-xs font-semibold">Save Sponsor Company</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
