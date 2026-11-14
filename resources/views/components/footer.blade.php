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

        <!-- Middle Tier: High-Authority Directory Hubs & Pillar Recirculation Grid -->
        <div class="py-6 border-b border-[#F3F4F6] grid grid-cols-1 md:grid-cols-4 gap-6 text-xs">
            <!-- Col 1: Core Navigation Hubs -->
            <div>
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold block mb-2.5">Core Hubs</span>
                <ul class="space-y-1.5 font-sans">
                    <li><a href="{{ route('workflows.index') }}" class="font-bold text-[#111827] hover:text-[#6D28D9] transition-colors">Production AI Workflows →</a></li>
                    <li><a href="{{ route('mcp.index') }}" class="font-bold text-[#111827] hover:text-[#6D28D9] transition-colors">MCP Server Directory →</a></li>
                    <li><a href="{{ route('news.index') }}" class="font-bold text-[#111827] hover:text-[#6D28D9] transition-colors">Realtime AI News &amp; Benchmarks →</a></li>
                    <li><a href="{{ route('subscribe') }}#executive-tier" class="text-[#4B5563] hover:text-[#6D28D9] transition-colors">Executive AI Briefing</a></li>
                    <li><a href="https://deepakbagada.in/products" target="_blank" rel="noopener" class="text-[#4B5563] hover:text-[#6D28D9] transition-colors">Commercial Agent Toolkits ↗</a></li>
                </ul>
            </div>

            <!-- Col 2: Pillar Workflows -->
            <div>
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold block mb-2.5">Pillar Workflows</span>
                <ul class="space-y-1.5 text-[11px] text-[#4B5563]">
                    <li><a href="{{ url('/workflow/how-to-build-n8n-workflows-with-claude-code-6-steps') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="How to Build n8n Workflows with Claude Code">n8n Workflows with Claude Code (6 Steps)</a></li>
                    <li><a href="{{ url('/workflow/build-langgraph-sales-pipeline-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Build a LangGraph Sales Pipeline">LangGraph Autonomous Sales Pipeline</a></li>
                    <li><a href="{{ url('/workflow/how-to-automate-threat-remediation-with-n8n-agents-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Agentic Security Ops Automated Remediation">Agentic SecOps Threat Remediation</a></li>
                    <li><a href="{{ url('/workflow/how-to-supercharge-your-ai-workflows-with-mcp-servers-in-2026-1780332775193') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Supercharge AI Workflows with MCP">Supercharge Workflows with MCP Servers</a></li>
                    <li><a href="{{ url('/workflow/velian-n8n-natural-language-workflow-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Velian Natural Language n8n Workflows">Velian Natural Language n8n Automations</a></li>
                </ul>
            </div>

            <!-- Col 3: Verified MCP Servers -->
            <div>
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold block mb-2.5">Verified MCP Servers</span>
                <ul class="space-y-1.5 text-[11px] text-[#4B5563]">
                    <li><a href="{{ url('/mcp-directory/basert-vs-llamacpp-vs-mlx-apple-silicon-benchmarks-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="BaseRT vs llama.cpp vs MLX Benchmarks">BaseRT vs llama.cpp vs MLX Benchmarks</a></li>
                    <li><a href="{{ url('/mcp-directory/prometheus-metrics-kubernetes-cluster-diagnostics-mcp-server') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Prometheus Kubernetes Diagnostics MCP">Prometheus K8s Cluster MCP Server</a></li>
                    <li><a href="{{ url('/mcp-directory/otari-vs-portkey-vs-litellm-gateway-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Otari vs Portkey vs LiteLLM Gateway">Otari vs Portkey vs LiteLLM Gateway</a></li>
                    <li><a href="{{ url('/mcp-directory/how-to-vision-driven-ecommerce-price-intelligence-2026') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Vision-Driven Price Intelligence">Vision-Driven Price Intelligence MCP</a></li>
                    <li><a href="{{ url('/mcp-directory/ai-driven-api-generation-gemini-flask') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="AI-Driven API Generation with Gemini">Gemini Flash REST API Generation MCP</a></li>
                </ul>
            </div>

            <!-- Col 4: Benchmarks & Showdowns -->
            <div>
                <span class="font-mono text-[10px] uppercase tracking-widest text-[#6D28D9] font-bold block mb-2.5">Frontier Benchmarks</span>
                <ul class="space-y-1.5 text-[11px] text-[#4B5563]">
                    <li><a href="{{ url('/blogs/tensorrt-llm-vs-sglang-blackwell-fp4-serving-speculative-showdown') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="TensorRT-LLM vs SGLang Blackwell FP4 Showdown">TensorRT-LLM vs SGLang FP4 Showdown</a></li>
                    <li><a href="{{ url('/blogs/crewai-vs-langgraph-2026-prototype-fast-harden-slow-hybrid') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="CrewAI vs LangGraph Enterprise Showdown">CrewAI vs LangGraph Enterprise Showdown</a></li>
                    <li><a href="{{ url('/blogs/agentic-rag-2026-reasoning-augmented-retrieval-beats') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Agentic RAG vs Vanilla RAG">Agentic RAG Reasoning-Augmented Retrieval</a></li>
                    <li><a href="{{ url('/blogs/owasp-top-10-llm-applications-2026-complete-agentic-ai') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="OWASP Top 10 for LLM Applications">OWASP Top 10 LLM Security Audit</a></li>
                    <li><a href="{{ url('/blogs/google-adk-2026-enterprise-multi-agent-systems-native-a2a') }}" class="hover:text-[#6D28D9] transition-colors line-clamp-1" title="Google ADK Multi-Agent Systems Native A2A">Google ADK Enterprise Native A2A Protocol</a></li>
                </ul>
            </div>
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
                <span>Editorial Review: <strong class="font-sans font-semibold text-[#111827]">Daily AI World Editorial Board</strong></span>
                <span class="text-gray-300 select-none">·</span>
                <span>Built by <a href="https://deepakbagada.in/" target="_blank" rel="noopener noreferrer" class="font-sans font-semibold text-[#111827] hover:text-[#5B21B6] underline decoration-gray-300 hover:decoration-[#5B21B6] transition-colors">Deepak Bagada</a></span>
            </div>
        </div>
    </div>
</footer>
