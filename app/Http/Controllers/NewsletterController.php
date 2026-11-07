<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeNewsletterAction;
use App\DTOs\NewsletterData;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request, SubscribeNewsletterAction $action)
    {
        // 1. Invisible Bot Honeypot Trap
        // If hidden honeypot fields are filled by an automated bot/scraper, fake success without saving
        if ($request->filled('b_hp_url') || $request->filled('website') || $request->filled('hp_email')) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for subscribing! Check your inbox for confirmation.',
                    'data' => [
                        'email' => $request->input('email'),
                        'edition' => 'Daily Executive Briefing',
                    ]
                ]);
            }
            return back()->with('success', 'You have successfully subscribed to the Daily AI World executive briefing!');
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to the Daily AI World briefing list. A confirmation email has been sent to ' . $subscriber->email . '.',
                'data' => [
                    'email' => $subscriber->email,
                    'edition' => $subscriber->edition,
                ]
            ]);
        }

        return back()->with('success', 'You have successfully subscribed to the Daily AI World executive briefing! Please check your inbox for confirmation.');
    }
}
