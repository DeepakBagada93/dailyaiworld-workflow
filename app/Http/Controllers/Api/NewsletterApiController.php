<?php

namespace App\Http\Controllers\Api;

use App\Actions\SubscribeNewsletterAction;
use App\DTOs\NewsletterData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsletterApiController extends Controller
{
    public function subscribe(Request $request, SubscribeNewsletterAction $action)
    {
        // 1. Invisible Bot Honeypot Trap
        if ($request->filled('b_hp_url') || $request->filled('website') || $request->filled('hp_email')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully subscribed to Daily AI World executive briefing.',
                'data' => [
                    'email' => $request->input('email'),
                    'edition' => 'Daily Executive Briefing',
                ],
            ]);
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'edition' => 'nullable|string|max:100',
        ]);

        $data = new NewsletterData(
            email: $validated['email'],
            edition: $validated['edition'] ?? 'Daily Executive Briefing'
        );

        $subscriber = $action->execute($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully subscribed to Daily AI World executive briefing.',
            'data' => [
                'email' => $subscriber->email,
                'edition' => $subscriber->edition,
            ],
        ]);
    }
}
