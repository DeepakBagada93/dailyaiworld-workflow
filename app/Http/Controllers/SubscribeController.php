<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('status', 'active')->get();
        $totalImpressions = Sponsorship::sum('impressions');
        $activeSponsorships = Sponsorship::where('status', 'active')->count();

        return view('subscribe', compact('sponsors', 'totalImpressions', 'activeSponsorships'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'plan' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Record inquiry as subscription lead / prospect
        Subscription::create([
            'user_id' => $user?->id,
            'email' => $validated['email'],
            'plan' => $validated['plan'] ?? 'executive',
            'amount' => 0.00,
            'status' => 'pending_inquiry',
            'stripe_subscription_id' => 'inquiry_' . strtoupper(substr(md5(uniqid()), 0, 12)),
            'current_period_end' => now()->addDays(365),
        ]);

        return redirect()->back()->with('success', 'Thank you for your Executive Tier inquiry! Our team will contact you directly via email. You can also reach out anytime at connect@saasnext.in.');
    }
}

