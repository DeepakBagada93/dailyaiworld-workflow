<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscribeController extends Controller
{
    public function index()
    {
        $monthlyPrice = 19;
        $annualPrice = 190;

        return view('subscribe', compact('monthlyPrice', 'annualPrice'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'plan' => 'required|in:monthly,annual',
        ]);

        $amount = $validated['plan'] === 'annual' ? 190.00 : 19.00;
        $periodDays = $validated['plan'] === 'annual' ? 365 : 30;

        $user = Auth::user();

        $subscription = Subscription::create([
            'user_id' => $user?->id,
            'email' => $validated['email'],
            'plan' => $validated['plan'],
            'amount' => $amount,
            'status' => 'active',
            'stripe_subscription_id' => 'sub_sim_' . strtoupper(substr(md5(uniqid()), 0, 12)),
            'current_period_end' => now()->addDays($periodDays),
        ]);

        return redirect()->route('home')->with('success', 'Welcome to Daily AI World Executive Tier! Your subscription is now active.');
    }
}
