<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to the Daily AI World briefing list.',
            ]);
        }

        return back()->with('success', 'You have successfully subscribed to the Daily AI World executive briefing.');
    }
}
