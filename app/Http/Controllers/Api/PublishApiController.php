<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticlePublishingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishApiController extends Controller
{
    protected ArticlePublishingService $publishingService;

    public function __construct(ArticlePublishingService $publishingService)
    {
        $this->publishingService = $publishingService;
    }

    /**
     * Store and publish content submitted from external AI tools (Antigravity, OpenCode, Codex CLI, etc.)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'deck'           => 'required|string',
            'content'        => 'required|string',
            'category_id'    => 'nullable|integer',
            'type'           => 'nullable|string|in:workflow,mcp,blog',
            'tier'           => 'nullable|string',
            'featured_image' => 'nullable|string|url',
            'reading_time'   => 'nullable|integer',
            'published_at'   => 'nullable|date',
            'status'         => 'nullable|string|in:published,draft,scheduled',
            'key_takeaways'  => 'nullable|array',
            'faqs'           => 'nullable|array',
            'ai_summary'     => 'nullable|string',
            'excerpt'        => 'nullable|string',
        ]);

        $result = $this->publishingService->publish($validated);

        if (!$result['local_status'] && !$result['remote_status']) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to publish to both Local and Remote hostinger databases.',
                'errors'  => [
                    'local'  => $result['local_error'] ?? null,
                    'remote' => $result['remote_error'] ?? null,
                ],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Article successfully published to database and live site!',
            'data'    => $result,
        ], 201);
    }
}
