<footer class="border-t border-[#E8E7EF] bg-[#FFFFFF] py-10 mt-20" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Top Tier: Navigation & Policy Links -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-6 border-b border-[#F3F4F6] text-xs font-mono text-[#4B5563]">
            <!-- Brand & Tagline -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Daily AI World Logo" class="w-7 h-7 rounded-full object-cover shrink-0">
                <div>
                    <span class="font-bold text-[#111827] text-sm font-serif block">Daily AI World</span>
                    <span class="text-[11px] text-[#6B7280]">AI Workflows, MCP Directory & Intelligence</span>
                </div>
            </div>

            <!-- Primary & Legal Links -->
            <div class="flex flex-wrap items-center justify-center md:justify-end gap-x-4 gap-y-2 text-center">
                <a href="{{ route('about') }}" class="hover:text-[#5B21B6] transition-colors font-medium">About Us</a>
                <span class="text-gray-300">·</span>
                <a href="{{ route('contact') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Contact</a>
                <span class="text-gray-300">·</span>
                <a href="{{ route('privacy') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Privacy Policy</a>
                <span class="text-gray-300">·</span>
                <a href="{{ route('terms') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Terms of Service</a>
                <span class="text-gray-300">·</span>
                <a href="{{ route('disclaimer') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Disclaimer</a>
                <span class="text-gray-300">·</span>
                <a href="{{ route('advertise') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Advertise</a>
            </div>
        </div>

        <!-- Bottom Tier: Technical Feeds, Copyright & Attribution -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-[#6B7280]">
            <div>
                <span>© {{ date('Y') }} Daily AI World. All rights reserved.</span>
            </div>
            
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-2 text-center sm:text-right text-[11px]">
                <a href="{{ route('sitemap') }}" class="hover:text-[#5B21B6] underline">Sitemap.xml</a>
                <span class="text-gray-400">·</span>
                <a href="{{ route('feed') }}" class="hover:text-[#5B21B6] underline">RSS Feed</a>
                <span class="text-gray-400">·</span>
                <a href="{{ route('llms.txt') }}" class="hover:text-[#5B21B6] underline">LLMs.txt</a>
                <span class="text-gray-400">·</span>
                <span>Made by <a href="https://saasnext.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-300 hover:decoration-[#5B21B6] transition-colors">SaaSNext</a></span>
                <span class="text-gray-400">·</span>
                <span>Managed by <strong class="font-sans font-semibold text-[#5B21B6]">AI Agents</strong></span>
                <span class="text-gray-400">·</span>
                <span>Built by <a href="https://deepakbagada.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-300 hover:decoration-[#5B21B6] transition-colors">Deepak Bagada</a></span>
            </div>
        </div>
    </div>
</footer>
