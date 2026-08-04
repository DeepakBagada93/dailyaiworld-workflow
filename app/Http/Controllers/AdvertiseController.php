<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('status', 'active')->get();
        $totalImpressions = Sponsorship::sum('impressions');
        $activeSponsorships = Sponsorship::where('status', 'active')->count();

        return view('subscribe', compact('sponsors', 'totalImpressions', 'activeSponsorships'));
    }

    public function submitLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'placement_interest' => 'required|string',
            'budget' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        // Record sponsor inquiry as a prospect
        Sponsor::create([
            'name' => $validated['company'],
            'contact_email' => $validated['email'],
            'website_url' => 'https://' . strtolower(str_replace(' ', '', $validated['company'])) . '.com',
            'status' => 'prospect',
            'notes' => 'Contact: ' . $validated['name'] . ' | Interest: ' . $validated['placement_interest'] . ' | Budget: ' . ($validated['budget'] ?? 'Unspecified') . ' | Message: ' . ($validated['message'] ?? 'None'),
        ]);

        return redirect()->back()->with('success', 'Thank you for your inquiry! Our editorial team will contact you directly via email. You can also reach out to us at connect@saasnext.in.');
    }
}

