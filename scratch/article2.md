There is a moment in every voice-agent rollout where a caller stops mid-sentence and hangs up. Usually the cause is not the model; it is the latency between the end of the user's turn and the first audible word of the reply. In 2026, a real-time voice agent that feels natural is judged on a sub-second loop: roughly 700-800ms from end-of-turn to the first TTS buffer. For an aggressive sub-300ms perceived target, the personality of the stack matters more than the choice of model vendor. Every vendor publishes benchmarks, but the real numbers are won in the streaming architecture, the region, and the turn-taking logic.

The most reliable production pattern in 2026 remains the cascaded STT-to-LLM-to-TTS pipeline, because it gives you a plain-text audit trail, per-stage swap-ability, and mature tool calling. Real-time speech-to-speech models are more natural and faster for some flows, but they are still maturing for complex, tool-heavy use cases that need structured function calls and auditability. This article walks through a streaming real-time voice pipeline targeting sub-300ms perceived latency, covering VAD and turn detection, Whisper-family streaming STT, fast LLM orchestration with tool calling, streaming TTS with barge-in, and confidence-threshold-based human escalation.

## The Latency Budget

The end-to-end loop feels smaller than the sum of its parts when the stages overlap. The numbers below are representative mid-2026 floors for a well-co-located stack running a small model on the common path.

| Stage | Team | Typical floor | Role |
| --- | --- | --- | --- |
| VAD + turn detection | silero VAD / neural | 40-150ms | marks end-of-speech |
| STT streaming final | Whisper-family / AI3 | 120-250ms | transcript |
| LLM time-to-first-token | fast model + speculative | 150-350ms | reasoning + tools |
| TTS first buffer | streaming neural TTS | 150-300ms | first audio |
| Network / scheduling | co-located regions | 30-80ms | travel + jitter |

```text
  User mic -> VAD -> streaming STT -> LLM orchestrator -> streaming TTS -> audio out
      (40ms)      (120ms)      (250ms TTFT)            (200ms first buf)    ~<300ms perceived
```

The trick is that this total is not a sum of serial screenshots. The stages overlap: STT streams partial hypotheses to the LLM, the LLM cold-starts a draft on those partials, and the TTS starts synthesizing silently on the first tokens before the LLM has finished. If you serialize the stages, the same numbers total more than one second. Streaming is precisely what makes the cascade feel real-time.

## Project Scaffold

A clean service separates each stage into its own module so you can swap a provider without touching the rest.

```text
voice_agent/
  .env
  pyproject.toml
  agent/
    vad.py
    stt.py
    llm.py
    tts.py
    tools.py
    session.py
    main.py
  tests/
    test_turn.py
```

Configuration belongs in `.env`.

```text
# .env
STT_PROVIDER=deepgram
STT_MODEL=nova-3
LLM_PROVIDER=openai
LLM_MODEL=gpt-4.1-mini        # fast path
LLM_FAST_MODEL=gpt-4o-mini    # speculative / simple turns
TTS_PROVIDER=cartesia
TTS_VOICE=...
VAD_MODEL=silero
LIVEKIT_URL=wss://<your-livekit>.livekit.cloud
```

## Stage 1: VAD and Turn Detection

Voice activity detection finds when speech starts and, far more importantly for latency, when the user has finished. A bad VAD either interrupts the caller or pads the turn with silence waiting for a timeout that never fires. Modern stacks use a neural or multimodal turn-detection model instead of a bare silence threshold to reduce false endings that otherwise add an extra round-trip on every turn.

```python
# vad.py
from silero_vad import load_silero_vad, read_audio, get_speech_timestamps


class VAD:
    def __init__(self):
        self.model = load_silero_vad()

    def feed_audio(self, chunk, sr=16000):
        ts = get_speech_timestamps(read_audio(chunk, sampling_rate=sr), self.model)
        return bool(ts)

    def end_of_turn(self, chunk, idle_ms=700):
        return not self.feed_audio(chunk) and self.silence_budget() > idle_ms
```

Turn detection driven by a neural or multimodal endpoint is markedly better at end-of-speech than fixed thresholds, and it matters: a single false detection can add a full 700ms turn round-trip to a sub-second budget.

## Stage 2: Streaming Speech-to-Text

Streaming STT returns partial hypotheses before the final transcript. Each partial and the final transcript carry a confidence score. The partials accelerate the LLM, and the confidence score drives the escalation policy. Choose the provider model you already trust for the language mix the call will actually use, because accuracy is a trust-builder in the first sentence.

```python
# stt.py
async def transcribe(stream):
    async for event in stt.stream():
        if event.type in ("partial", "final"):
            alt = event.alternatives[0]
            yield alt.transcript, alt.confidence, event.type == "final"
```

Never wait for the final transcript to fire the LLM. Feed the growing partial so the downstream model already has context and can produce its first token earlier. This single choice is the biggest win in the STT handoff.

## Stage 3: LLM Orchestration With Tool Calling

The orchestrator receives streaming transcript tokens, builds a prompt that merges in memory and tool definitions, and streams its response tokens so the TTS can begin early. It must also support a tool call mid-response without a long dead air.

```python
# llm.py
from livekit import agents


class LLMOrchestrator:
    def __init__(self, model, tools):
        self.llm = agents.LLM(model=model)
        self.tools = tools

    async def respond(self, transcript: str, memory) -> agents.chat.ChatContext:
        ctx = agents.chat.ChatContext.from_user_message(transcript)
        ctx.tools = [self.tools]      # expose tools to the model
        return self.llm.stream(ctx)   # yields tokens, stream first token fast
```

### When a Tool Is Invoked

A tool call pauses the LLM while it awaits a real API such as room availability, a CRM lookup, or a payment check. That journey can add hundreds of milliseconds of external latency on top of a second LLM round-trip. The proven fix is filler speech: play a short acknowledgement line such as "checking that for you" immediately before invoking the tool. This masks the otherwise silent five-to-ten second gap and is the single most effective perceived-latency lever after streaming itself.

```python
# tools.py
from livekit.agents import function_tool


@function_tool
async def get_room_availability(room: str, date: str) -> str:
    """Returns meeting-room availability for a booking query."""
    return await rooms.availability(room, date)
```

## Stage 4: Streaming TTS and Barge-In

Streaming TTS starts producing audio from the first partial tokens rather than waiting for a full sentence to be complete. Barge-in lets the user interrupt: the player stops immediately, and the loop returns to streaming STT.

```python
# tts.py
from livekit import agents


class StreamingTTS:
    def __init__(self, provider="cartesia", voice=None):
        self.tts = agents.TTS(provider=provider, voice)

    async def synthesize(self, token_stream):
        async for token in token_stream:
            async with self.tts.synthesis as synth:
                synth.push_input(token)
                for frame in synth.stream():
                    yield frame
```

## Putting It Together: The Session Loop

The session orchestrates the stages as a loop. It keeps a rolling transcript, feeds VAD, and on end-of-turn streams the LLM response into the TTS. The whole thing stays streaming-hot so no stage ever blocks a live audio path.

```python
# session.py
class VoiceSession:
    def __init__(self, vad, stt, llm, tts, tools):
        self.vad, self.stt, self.llm, self.tts, self.tools = vad, stt, llm, tts, tools

    async def run(self, audio):
        turn = ""
        async for event in audio:
            if self.vad.feed_audio(event):
                turn += (await anext(self.stt.transcribe(event)))[0]
            elif self.vad.end_of_turn(event):
                async for token in self.llm.stream_response(turn, memory):
                    await self.tts.play(token)
                turn = ""
```

## Confidence Thresholds and Human Escalation

Only a small subset of turns should ever reach a human. Discrete signals decide the policy: STT confidence, tool success, retry count, and how many times the conversation has spiraled. The table defines a conservative default.

| Condition | Policy |
| --- | --- |
| STT confidence > 0.9 and tool fast | answer directly |
| STT confidence 0.6-0.9 | confirm before committing |
| STT confidence < 0.6 | ask a clarifying question |
| Tool fails once | retry once |
| Tool fails twice or user keeps spiraling | transfer to a human agent |

```python
def decide(conf: float, tool_ok: bool, retries: int) -> str:
    if retries > 2 or conf < 0.6:
        return "escalate_human"
    if conf < 0.9:
        return "confirm"
    return "answer"
```

Escalation is a discrete human hand-off with the full transcript attached, so the human picks up with complete context. This is a compliance and trust win as much as a reliability win.

## Latency Tuning and Observability

Measure per-stage with the Agent Insights view: end-of-speech to turn detected, turn detected to first LLM token, first LLM token to first TTS chunk, and the per-call total. If the TTS voice drifts or "breaks" on bursty networks, raise `min_buffer_size` and `max_chunk_length` (for example 150 and up to 300) instead of chasing the raw latency floor. Co-locate STT, TTS, and LLM in the same region to avoid two network round-trips at every stage boundary.

Choose the model for the workload: a small fast model for the common path, a full-size model for genuine reasoning, and specifically optimize for time-to-first-token. Set `LANGCHAIN_TRACING_V2=true` and export per-turn spans with `stt_confidence`, `tool_calls`, and `turn_duration_ms` attached.

## Evaluation

Latency evaluation is per-stage instrumentation, not an end-to-end vibe check. Record `ttft`, `first_audio`, and `total` per call, plus transcript-level accuracy against a golden set with a pinned judge. Track both the media of the happy path and the tail for tool-heavy turns, because the tail is what callers notice.

## Closing

Sub-300ms is not won in the model; it is won in the pipeline one stage at a time. Streaming STT to LLM to TTS with overlapping execution gets you to the target; filler speech and async tools absorb tool latency; confidence thresholds and escalation keep low-confidence turns from hurting real callers. For more on orchestrators and tool enablement, explore the [workflows hub](https://dailyaiworld.com/workflows), the [MCP directory](https://dailyaiworld.com/mcp-directory) for the tools a voice agent calls, and the [latest AI news](https://dailyaiworld.com/latest-ai-news) for the faster model releases that keep shrinking the budget.

**By Deepak Bagada, CEO at SaaSNext & Principal AI Architect.**