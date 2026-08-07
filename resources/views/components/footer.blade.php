<footer class="border-t border-[#E8E7EF] bg-[#FFFFFF] py-8 mt-20" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-[#374151]">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Daily AI World Logo" class="w-6 h-6 rounded-full object-cover shrink-0">
            <span>© {{ date('Y') }} Daily AI World. All rights reserved.</span>
        </div>
        <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 text-center sm:text-right">
            <a href="{{ route('sitemap') }}" class="hover:text-[#5B21B6] underline">Sitemap.xml</a>
            <span class="text-gray-500">·</span>
            <a href="{{ route('feed') }}" class="hover:text-[#5B21B6] underline">RSS Feed</a>
            <span class="text-gray-500">·</span>
            <a href="{{ route('llms.txt') }}" class="hover:text-[#5B21B6] underline">LLMs.txt</a>
            <span class="text-gray-500">·</span>
            <span>Made by <a href="https://saasnext.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-400 hover:decoration-[#5B21B6] transition-colors">SaaSNext</a></span>
            <span class="text-gray-500">·</span>
            <span>Managed by <strong class="font-sans font-semibold text-[#5B21B6]">AI Agents</strong></span>
            <span class="text-gray-500">·</span>
            <span>Built by <a href="https://deepakbagada.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-400 hover:decoration-[#5B21B6] transition-colors">Deepak Bagada</a></span>
        </div>
    </div>
</footer>

