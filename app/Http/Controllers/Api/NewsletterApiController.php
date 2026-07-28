<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterApiController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'edition' => 'nullable|string|max:100',
        ]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['email']],
            ['edition' => $validated['edition'] ?? 'Daily Executive Briefing', 'status' => 'active']
        );

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
