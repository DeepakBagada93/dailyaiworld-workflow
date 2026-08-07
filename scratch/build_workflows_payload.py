import json

SCRATCH = "/Users/deepakbagada/personal/Daily AI world/scratch"
OUT = f"{SCRATCH}/workflows_payload.json"
IMG = "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80"


def load(p):
    with open(f"{SCRATCH}/{p}", encoding="utf-8") as f:
        return f.read().strip()


c1 = load("article1.md")
c2 = load("article2.md")
c3 = load("article3.md")

articles = [
    {
        "title": "Agentic Graph RAG Pipeline with Multi-Hop Reasoning, Self-Correction & Knowledge Graphs in LangGraph",
        "deck": "Move beyond retrieve-then-generate. Build a self-correcting agentic graph RAG pipeline in LangGraph that fuses vector search with a knowledge graph, decomposes complex queries into sub-goals, performs multi-hop reasoning, grades every retrieved chunk, and rewrites queries in a retry loop until the evidence is solid.",
        "ai_summary": "A production deep-dive into agentic graph RAG with LangGraph: a meta-agent to retriever to researcher to evaluator loop over a hybrid vector + knowledge-graph layer, with LLM-as-judge grading, rewrite-on-failure with a novelty guard, grounded generation with citations, and explicit retry and evaluation rules.",
        "content": c1,
        "category_id": 1,
        "featured_image": IMG,
        "seo_title": "Agentic Graph RAG Pipeline with Multi-Hop Reasoning in LangGraph | Daily AI World",
        "meta_description": "Agentic graph RAG in LangGraph: multi-hop reasoning, hybrid vector + knowledge-graph retrieval, LLM-as-judge grading, and self-correcting rewrite loops.",
        "seo_keywords": "agentic graph RAG, multi-hop reasoning, LangGraph RAG, knowledge graph, self-correcting RAG, LLM-as-judge",
        "key_takeaways": [
            "Agentic graph RAG treats retrieval as one tool call inside a stateful, cyclic LangGraph, grading evidence before it ever generates an answer.",
            "Multi-hop questions are solved by walking entity relations in a knowledge graph, which pure vector stores cannot express.",
            "Self-correction is a rewrite loop with a novelty guard and a recursion limit, so the system learns from failures instead of thrashing.",
        ],
        "faqs": [
            {
                "question": "What is agentic graph RAG?",
                "answer": "Agentic graph RAG is a LangGraph-based workflow that routes a query through a meta agent, hybrid retrieval (dense, sparse, and knowledge-graph), a researcher that performs multi-hop reasoning, and an LLM-as-judge evaluator. It self-corrects by rewriting failed queries in a retry loop and only generates a grounded, cited answer once the evidence passes.",
            },
            {
                "question": "How does self-correction work in agentic RAG?",
                "answer": "An evaluator grades each retrieved chunk with structured output (pass/fail plus a reason). If the evidence fails, a conditional edge routes execution to a rewrite node that reformulates the query and loops back to retrieval. A novelty check compares cosine similarity against previous rewrites to avoid semantic duplicates, and a recursion limit is the hard stop.",
            },
            {
                "question": "Why add a knowledge graph to a vector store?",
                "answer": "Vector stores capture semantic similarity but cannot express explicit entity-to-entity relationships or provenance. A knowledge graph (for example Neo4j) lets the researcher traverse multi-hop relations and merge structural facts, enabling questions that span multiple documents and entities.",
            },
            {
                "question": "What is LLM-as-judge in agentic RAG?",
                "answer": "LLM-as-judge means a structured-output LLM invocation evaluates another step. In agent RAG the evaluator grades retrieval relevance and answer faithfulness and decides whether to generate, rewrite, call a web-search fallback, or escalate to a human.",
            },
        ],
        "reading_time": 14,
    },
    {
        "title": "Real-Time AI Voice Agent Pipeline: STT, LLM Orchestration, TTS & Tool Calling Under 300ms Latency",
        "deck": "Engineer a real-time voice agent that streams speech-to-text, orchestrates an LLM with tool calling, and synthesizes speech so the conversational loop stays under 300ms perceived latency, with confidence thresholds and human escalation as safety nets.",
        "ai_summary": "A production blueprint for low-latency AI voice agents: cascaded streaming STT to LLM with tool calling to streaming TTS, VAD and turn detection, filler speech to mask tool latency, a sub-300ms latency budget, confidence thresholds, and human escalation.",
        "content": c2,
        "category_id": 1,
        "featured_image": IMG,
        "seo_title": "Real-Time AI Voice Agent Under 300ms: STT, LLM, TTS & Tool Calling | Daily AI World",
        "meta_description": "Build a real-time AI voice agent under 300ms: streaming STT, LLM orchestration with tool calling, streaming TTS with barge-in, and confidence thresholds.",
        "seo_keywords": "real-time voice agent, STT LLM TTS pipeline, voice agent latency, streaming TTS, tool calling voice agent, human escalation",
        "key_takeaways": [
            "The cascaded STT-to-LLM-to-TTS pipeline stays under 300ms only when stages overlap via streaming partials and tokens instead of serializing.",
            "Tool-call latency is masked with acknowledgment filler and fiber, plus a second LLM round-trip is budgeted, not hidden.",
            "Confidence thresholds route low-confidence turns to confirm or escalate to a human with full transcript context.",
        ],
        "faqs": [
            {
                "question": "How does a voice agent stay under 300ms latency?",
                "answer": "It overlaps the pipeline. Streaming STT emits partial transcripts to the LLM, the LLM streams its first tokens to a streaming TTS, and the TTS starts synthesizing audio from partial tokens. VAD, barge-in, and filler speech handle turn-taking. The LLM time-to-first-token dominates the budget.",
            },
            {
                "question": "Cascaded pipeline or speech-to-speech model for voice agents?",
                "answer": "In 2026 the cascaded STT-LLM-TTS pipeline remains the production default because it gives a plain-text audit trail, per-stage swap flexibility, and mature tool calling. Speech-to-speech models are more natural for some flows but still maturing for complex, tool-heavy use cases.",
            },
            {
                "question": "Why do voice agents play filler sound when calling tools?",
                "answer": "A tool call pauses the LLM while it awaits an external API. Instead of dead air, the agent plays an acknowledgment such as checking that for you before invoking the tool, masking the second round-trip and any API delay behind natural-sounding speech.",
            },
            {
                "question": "When should a voice agent hand off to a human?",
                "answer": "When STT confidence is repeatedly below a threshold, when a user interrupts continuously, or when a tool fails and retries are exhausted. Discrete policy rules decide between replying, confirming, or transferring to a human with the full transcript.",
            },
        ],
        "reading_time": 13,
    },
    {
        "title": "Persistent Agent Memory Architecture with mem0, LangGraph & Vector Store for Multi-Session Context",
        "deck": "Give agents durable memory. Combine mem0 as the universal memory layer with LangGraph orchestration and a vector store to persist user, session, and agent-level context across sessions, channels, and devices, with adaptive updates that avoid memory bloat.",
        "ai_summary": "A production architecture for persistent agent memory: mem0 as the memory layer (vector + graph + key-value), LangGraph as orchestration with checkpointing, vector-store durable retrieval, adaptive memory updates, multi-session context, and evaluation against LongMemEval.",
        "content": c3,
        "category_id": 1,
        "featured_image": IMG,
        "seo_title": "Persistent Agent Memory with mem0, LangGraph & Vector Store | Daily AI World",
        "meta_description": "Persistent agent memory with mem0, LangGraph, and a vector store: multi-session context, adaptive updates, scoping, and production evaluation.",
        "seo_keywords": "mem0, persistent agent memory, LangGraph memory, vector store, multi-session context, adaptive memory updates",
        "key_takeaways": [
            "Persistent memory separates thread-scoped LangGraph checkpointing from durable cross-session knowledge stored in mem0.",
            "mem0 combines vector, graph, and key-value storage with adaptive updates, so memory entries are merged, not blindly duplicated.",
            "The LangGraph integration is two extra nodes: a memory retrieval node before the LLM and an update node after it.",
        ],
        "faqs": [
            {
                "question": "What problem does mem0 solve for LangGraph agents?",
                "answer": "mem0 provides persistent, queryable memory for agents that otherwise operate on transient thread state. It turns a stateless graph into a system that remembers users, preferences, and facts across sessions and channels.",
            },
            {
                "question": "How does mem0 combine a vector store with a knowledge graph?",
                "answer": "mem0 stores dense embeddings for semantic similarity in a vector store, entity relationships in graph memory, and fast facts in a key-value cache. Adaptive memory updates extract facts, check overlap, and create, or discard, so repeated knowledge stays compact.",
            },
            {
                "question": "How do you integrate mem0 into a LangGraph agent?",
                "answer": "Add a retrieval node that calls memory search before the LLM and feeds facts into the prompt, and an update node that calls memory.add after the LLM responds. Different graphs can share one mem0 instance so user memory stays consistent across channels.",
            },
            {
                "question": "What are the latency and cost trade-offs of persistent memory?",
                "answer": "Vector retrieval is fast (about 10-50ms), graph traversal is 50-150ms, and LLM synthesis over retrieved memories costs 800-3000ms. Persistent memory cuts token cost for repeated tasks by 30-60%, but reads that use synthesis add latency. The common path uses vector retrieval.",
            },
        ],
        "reading_time": 13,
    },
]

with open(OUT, "w", encoding="utf-8") as f:
    json.dump(articles, f, ensure_ascii=False, indent=2)

print("WROTE", OUT)
for a in articles:
    print(a["title"], "|", len(a["content"].split()), "words")