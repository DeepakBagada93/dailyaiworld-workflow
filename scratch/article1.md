Classic RAG is a search tool. Agentic Graph RAG is a reasoning system. The observation sounds like a slogan, but it captures the single biggest shift in retrieval engineering between 2024 and 2026. A plain pipeline embeds a user query, fires it at a vector store, stuffs the top-k chunks into a prompt, and asks an LLM to answer. When the corpus is clean and the question is single-hop, that works well enough. When the question requires stitching facts from three different documents, tracing an entity relationship across a graph, or recovering from a retrieval miss, the linear pipeline fails silently. The model cannot tell you that the context is bad. It simply generates a confident, plausible-sounding answer built on wrong evidence.

Agentic Graph RAG is the answer to that gap. Built on LangGraph, it models the entire reasoning process as a stateful, cyclic graph that can branch, loop, and self-correct based on intermediate results. In the 2026 reference architecture every agent communicates through a shared typed state, and no agent calls another directly: the LangGraph runtime routes execution through conditional edges. A query flows through a meta agent, retrieval becomes one tool call inside a larger workflow, a researcher decomposes the question into sub-goals, an evaluator grades every retrieved chunk for relevance, and a rewriter reformulates the query and loops back until the evidence is solid. A knowledge graph adds the entity relations a pure vector store cannot see, and a hybrid retriever reranks candidates against the plan rather than the raw question.

## Why Cascade RAG Reached Its Ceiling

The classic pattern is a straight line.

```text
User -> embed -> vector store -> top-k -> LLM -> answer
```

Each arrow is a fixed step. There is no route back and there are no decisions. The failure modes are well documented in the literature on adaptive RAG. Single-shot retrieval means that if the first search misses, the whole answer is built on nothing. Limited reasoning means a multi-hop question, one whose answer requires facts from several sources you cannot know in advance, gets flattened into a single vector search. Self-correction is essentially absent. Memory is stateless, so the system never learns from past failures or past successes. A vector-only system also misses the relations that only exist as edges between entities, which is precisely where a knowledge graph earns its place.

## The Agentic Graph RAG Reference Architecture

The architecture below mirrors the pattern used in self-correcting agentic RAG reference implementations and graph-centric decision-support research in 2025 and 2026. A meta agent routes the query, a planner breaks it into sub-goals, the retriever searches hybrid stores, the researcher walks the knowledge graph, and the evaluator grades the evidence and triggers a self-correction loop until it passes.

```text
                        +----------------------+
                        |     USER QUERY        |
                        +----------------------+
                                    |
                                    v
                        +----------------------+
                        |      META AGENT       |  route: in_scope / decline
                        +----------------------+
                     out_of_scope          in_scope
                         |                    |
                         v                    v
                       [END]         +----------------------+
                                     |      PLANNER          |  sub-goals + entities
                                     +----------------------+
                                                |
                                                v
                       +----------------------------------------+
                       |          RETRIEVER (hybrid)            |
                       |   dense + sparse fusion + graph walk   |
                       +----------------------------------------+
                                                |
                                                v
                       +----------------------------------------+
                       |         RESEARCHER                     |
                       |   multi-hop graph traversal + rerank   |
                       +----------------------------------------+
                                                |
                                                v
                       +----------------------------------------+
                       |     EVALUATOR (LLM-as-judge)           |
                       |   grade relevance / grounded evidence  |
                       +----------------------------------------+
                     fail                      pass
                       |                        |
                       v                        v
               +---------------+
               |   REWRITE      |
               |  novelty-check |
               +---------------+
                       |                       +----------------------+
                       +---------------------->|  ANSWER + CITATIONS   |
                              (loop back)     +----------------------+
```

The retry loop is the heart of the design. If the evaluator flags the evidence as irrelevant, a conditional edge routes execution back to the rewrite node, which reformulates the query and retrieves again, up to a configurable cap. The loop is bounded by both a rewrite-round count and a graph-level recursion limit, so it can never spin forever.

## Project Layout

A clean project is organized by responsibility.

```text
agentic_graph_rag/
  .env
  pyproject.toml
  src/
    agentic_rag/
      schemas.py        shared typed graph state
      embedder.py       embeddings + reranker
      retriever.py      hybrid search + fusion
      graph_store.py    Neo4j traversal tools
      nodes.py          meta, planner, researcher, rewrite
      judge.py          LLM-as-judge grading
      graph.py          StateGraph assembly
      main.py           FastAPI entrypoint
  data/
    qa_set.jsonl        evaluation set
    corpus/             documents to index
```

Configuration lives in `.env` and is loaded once at startup.

```text
# .env                                 [do not commit]
OPENAI_API_KEY=sk-...
OPENROUTER_API_KEY=sk-...
TAVILY_API_KEY=tvly-...              # optional web-search fallback
EMBED_MODEL=BAAI/bge-large-en-v1.5
RERANK_MODEL=BAAI/bge-reranker-v2-m3
QDRANT_URL=http://localhost:6333
QDRANT_COLLECTION=agentic_rag
NEO4J_URI=bolt://localhost:7687
NEO4J_USER=neo4j
NEO4J_PASSWORD=...
MAX_REWRITE_ROUNDS=3
NOVELTY_COSINE_THRESHOLD=0.90
RECURSION_LIMIT=50
RETRIEVAL_LIMIT=15
```

## The Shared State

LangGraph is built on a typed shared state that every node reads from and writes to, and the engine decides what runs next. Using an `Annotated` reduction on the documents field means every retriever appends candidates without overwriting earlier rounds, so the evaluator can re-grade all prior context as the graph loops. This is the subtle difference between a loop that monotonically improves and one that silently discards old evidence.

```python
# schemas.py
from typing import TypedDict, Annotated, Literal, Any
from operator import add


class Document(TypedDict):
    content: str
    source: str
    score: float
    entity_ids: list[str]


class AgentState(TypedDict):
    query: str
    rewrite_history: list[str]
    plan: list[str]
    documents: Annotated[list[Document], add]
    verdicts: list[Any]
    grounded: bool
    iteration: int
```

## The Meta Agent

A small, cheap model runs first to decide scope and to decompose the query into sub-goals. This is the model-routing pattern of 2026: light side-tasks for small models, deep reasoning and verification for large models. The meta agent emits structured output rather than a free-form stream.

```python
# nodes.py  (meta + planner)
from pydantic import BaseModel


class Plan(BaseModel):
    in_scope: bool
    reason: str
    sub_goals: list[str]
    entities: list[str]


async def run_meta(llm, query: str) -> Plan:
    structured = llm.with_structured_output(Plan)
    return await structured.ainvoke(
        "You are the meta agent. Decide scope, then decompose the query into "
        "2-4 sub-goals and list the key entities to trace in the knowledge graph. "
        f"Query: {query}"
    )
```

Declining an out-of-scope query costs zero retrieval and zero generation tokens. That is an easy cost win and a fine first line of defence against hallucination.

## Hybrid Retrieval

Retrieval is a tool the researcher decides to use, not a hardwired first step. It runs dense, sparse, and graph queries concurrently and reranks the union against the plan.

```python
# retriever.py
from qdrant_client import AsyncQdrantClient
from qdrant_client.http import models as qm


class HybridRetriever:
    def __init__(self, url: str, collection: str, embed, rerank):
        self.client = AsyncQdrantClient(url=url)
        self.collection = collection
        self.embed = embed
        self.rerank = rerank

    async def search(self, query: str, top_k: int = 12) -> list[dict]:
        vec = await self.embed(query)
        hits = await self.client.query_points(
            collection_name=self.collection,
            prefetch=[
                qm.Prefetch(query=vec, using="dense", limit=150),
                qm.Prefetch(query=query, using="sparse", limit=80),
            ],
            query=qm.FusionQuery(fusion=qm.Fusion.RRF),
            limit=top_k * 2,
        )
        docs = [
            {"content": p.payload["text"], "source": p.payload["source"], "score": p.score}
            for p in hits.points
        ]
        return self.rerank(query, docs, top_k=top_k)
```

Fusing dense and sparse embeddings with reciprocal rank fusion keeps exact-term recall (identifiers, product codes) without sacrificing semantic recall. A cross-encoder reranker then scores the candidates against the plan, not merely against the query string. That rerank-against-plan distinction is what separates agentic retrieval from a bare vector search.

## The Researcher and Multi-Hop Reasoning

The researcher resolves multi-hop relations by walking the knowledge graph. A clinically realistic question such as "which drugs interact with metformin and appear in the type 2 diabetes pathway" requires two hops through entities, which no single embedding lookup can reproduce reliably.

```python
# graph_store.py
from neo4j import AsyncGraphDatabase


class KnowledgeGraph:
    def __init__(self, uri: str, user: str, password: str):
        self.driver = AsyncGraphDatabase.driver(uri, auth=(user, password))

    async def traverse(self, entity_ids: list[str], max_depth: int = 2) -> list[dict]:
        query = """
        MATCH p=(a)-[*1..{depth}]-(b)
        WHERE a.id IN $ids
        RETURN a.id AS src, b.id AS dst, b.name AS label,
               b.features AS facts
        LIMIT 200
        """.replace("{depth}", str(max_depth))
        async with self.driver.session() as s:
            res = await s.run(query, ids=entity_ids)
            return [dict(r) for r in await res.data()]
```

Graph traversal is deterministic code, not an extra LLM hop. The structural facts the graph returns surface relations that a flat vector store cannot express, and their provenance is explicit.

## The Evaluator: LLM-as-Judge

The evaluator grades each retrieved chunk and the composite evidence set. Its structured output decides pass, rewrite, web-search fallback, or escalation.

```python
# judge.py
from pydantic import BaseModel


class Verdict(BaseModel):
    relevant: bool
    score: float
    reason: str


class Composite(BaseModel):
    grounded: bool
    coverage_gap: list[str]
    decision: Literal["pass", "rewrite", "websearch", "escalate"]


async def grade(state: AgentState, llm) -> dict:
    verdicts = []
    for d in state["documents"]:
        v = llm.with_structured_output(Verdict).invoke(
            f"Document: {d['content'][:1000]}\\nQuery: {state['query']}\\nRelevant?"
        )
        verdicts.append(v)
    any_relevant = any(v.relevant for v in verdicts)
    return {"verdicts": verdicts, "grounded": any_relevant}
```

Coverage is checked both by the LLM and by deterministic gap extraction: required entities and periods are pulled from the query through a structured call, then matched against the retrieved chunks. This mix of LLM judgment and code-based checks is what keeps the loop from rewarding confident-but-empty answers.

## The Rewrite-and-Loop

When grading fails, the query is rewritten, but only if the rewrite is novel. The novelty check embeds the candidate rewrite and compares it to the rewrite history; if the cosine similarity exceeds the threshold, the loop treats it as a duplicate and jumps straight to a web-search fallback. This anti-thrash guard is the difference between a system that learns and one that loops.

```python
# graph.py  (self-correction edges)
from langgraph.graph import StateGraph, START, END

builder = StateGraph(AgentState)
builder.add_node("meta", run_meta)
builder.add_node("plan", plan_subgoals)
builder.add_node("retrieve", retrieve_hybrid)
builder.add_node("traverse", traverse_graph)
builder.add_node("evaluate", evaluate)
builder.add_node("rewrite", rewrite_query)
builder.add_node("generate", generate_grounded)

builder.add_edge(START, "meta")
builder.add_conditional_edges(
    "meta",
    lambda s: "plan" if s.get("in_scope", True) else END,
    {"plan": "plan", "end": END},
)
builder.add_edge("plan", "retrieve")
builder.add_edge("retrieve", "traverse")
builder.add_edge("traverse", "evaluate")
builder.add_conditional_edges(
    "evaluate",
    lambda s: "generate" if s["grounded"] else "rewrite",
    {"generate": "generate", "rewrite": "rewrite"},
)
builder.add_edge("rewrite", "retrieve")   # the self-correcting loop
builder.add_edge("generate", END)

graph = builder.compile(checkpointer=checkpointer, recursion_limit=RECURSION_LIMIT)
```

The recursion limit is the hard cap; the rewrite counter is the soft cap. Both belong in the compiled graph so a pathological path can never burn an unbounded token budget.

## Grounded Generation With Citations

The generator is allowed to use only the retrieved context. It cannot synthesize out-of-scope knowledge, and it cites each claim against the source list.

```python
# nodes.py
def generate_grounded(state: AgentState) -> dict:
    for claim in extract_claims(state):
        if not resolve(claim, state["documents"]):
            return {"generation": "Answer could not be fully grounded.", "grounded": False}
    prompt = (
        "Answer ONLY from the retrieved context. Cite each claim with [n]. "
        "If the context is insufficient, say so explicitly.\\n\\n" + bundle(state)
    )
    return {"generation": llm_gen(prompt), "grounded": True}
```

## Retry Rules, Error Handling, and Evaluation

A production agent needs explicit rules, not silent degradation. The table below captures the standard policy matrix.

| Condition | Action | Budget |
| --- | --- | --- |
| Judge passes evidence | generate grounded answer | minimal |
| Judge fails evidence | rewrite query (novelty-checked) | up to 3 rounds |
| Re-query duplicate (cos > 0.90) | skip to web-search fallback | 1 tool |
| Vector + graph both miss | Tavily web search | 1 call |
| Web search still fails | escalate to human / abstain | system-level |
| LLM timeout or 5xx | retry with exponential backoff, max 3 | resilience |
| Graph fan-out too large | depth <= 2, LIMIT 200 | prevents explosion |

> **The loop is not a bug; it is the feature.** A single conditional edge is the whole difference between a pipeline and an agent. Your query has a rewrite, a judge, a retry, and a grounded output only because the graph is allowed to cycle.

## Evaluation and Observability

Track faithfulness, context precision, and iteration count per query. A question that needs more than two rewrites is usually a chunking or indexing problem, not a prompt problem. Trace every node with LangSmith and attach the `iteration`, `critic_reason`, and `token_budget` to each span so operations can see exactly where cost leaks.

```text
LANGCHAIN_TRACING_V2=true
LANGCHAIN_API_KEY=lsv2_...
OTEL_EXPORTER_OTLP_ENDPOINT=http://otel:4317
```

## When Agentic Graph RAG Pays Off

The honest caveat: if your corpus fits the context window, a load-and-ask approach is cheaper and easier to debug. Agentic graph RAG earns its complexity when the knowledge base is far larger than context, when multi-hop questions cross sources you cannot know in advance, or when tool use is required. Always benchmark both approaches before committing months of engineering. To keep the surrounding stack current, browse the [workflows hub](https://dailyaiworld.com/workflows) for more LangGraph patterns, pair retrieval with MCP tools from the [MCP directory](https://dailyaiworld.com/mcp-directory), and follow the model releases that push latency and quality in the [latest AI news](https://dailyaiworld.com/latest-ai-news).

**By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.**