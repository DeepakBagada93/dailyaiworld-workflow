<footer class="border-t border-[#E8E7EF] bg-[#FFFFFF] py-8 sm:py-10 mt-16 sm:mt-20" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Top Tier: Navigation & Policy Links -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-6 border-b border-[#F3F4F6]">
            <!-- Brand & Tagline -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none shrink-0">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Daily AI World Logo" 
                     width="28" 
                     height="28" 
                     class="w-7 h-7 min-w-[28px] max-w-[28px] h-[28px] max-h-[28px] rounded-full object-cover shrink-0 ring-1 ring-purple-100 group-hover:ring-[#5B21B6] transition-all"
                     style="width: 28px; height: 28px; min-width: 28px; max-width: 28px; object-fit: cover;">
                <div class="text-left">
                    <span class="font-bold text-[#111827] text-sm font-serif group-hover:text-[#5B21B6] transition-colors leading-tight block">Daily AI World</span>
                    <span class="text-[11px] font-mono text-[#6B7280] leading-none block">AI Workflows, MCP Directory & Intelligence</span>
                </div>
            </a>

            <!-- Primary & Legal Links -->
            <nav aria-label="Footer Legal and Company Links" class="flex flex-wrap items-center justify-center md:justify-end gap-x-3 sm:gap-x-4 gap-y-2 text-xs font-mono text-[#4B5563]">
                <a href="{{ route('about') }}" class="hover:text-[#5B21B6] transition-colors font-medium">About Us</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('contact') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Contact</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('privacy') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Privacy Policy</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('terms') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Terms of Service</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('disclaimer') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Disclaimer</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('advertise') }}" class="hover:text-[#5B21B6] transition-colors font-medium">Advertise</a>
            </nav>
        </div>

        <!-- Bottom Tier: Technical Feeds, Copyright & Attribution -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-[#6B7280]">
            <div class="text-center sm:text-left">
                <span>© {{ date('Y') }} Daily AI World. All rights reserved.</span>
            </div>
            
            <div class="flex flex-wrap items-center justify-center sm:justify-end gap-x-2.5 gap-y-1.5 text-center sm:text-right text-[11px]">
                <a href="{{ route('sitemap') }}" class="hover:text-[#5B21B6] underline">Sitemap.xml</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('feed') }}" class="hover:text-[#5B21B6] underline">RSS Feed</a>
                <span class="text-gray-300 select-none">·</span>
                <a href="{{ route('llms.txt') }}" class="hover:text-[#5B21B6] underline">LLMs.txt</a>
                <span class="text-gray-300 select-none">·</span>
                <span>Made by <a href="https://saasnext.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-300 hover:decoration-[#5B21B6] transition-colors">SaaSNext</a></span>
                <span class="text-gray-300 select-none">·</span>
                <span>Managed by <strong class="font-sans font-semibold text-[#5B21B6]">AI Agents</strong></span>
                <span class="text-gray-300 select-none">·</span>
                <span>Built by <a href="https://deepakbagada.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-300 hover:decoration-[#5B21B6] transition-colors">Deepak Bagada</a></span>
            </div>
        </div>
    </div>
</footer>
