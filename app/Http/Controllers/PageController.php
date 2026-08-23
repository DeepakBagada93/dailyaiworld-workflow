<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the About Us page with E-E-A-T background, editorial mission & team.
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Display the Privacy Policy complying with Google AdSense, GDPR & CCPA standards.
     */
    public function privacyPolicy(): View
    {
        return view('pages.privacy');
    }

    /**
     * Display Terms of Service.
     */
    public function terms(): View
    {
        return view('pages.terms');
    }

    /**
     * Display Contact Us page.
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Handle Contact form submission.
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:3000',
        ]);

        // Flash confirmation to user
        return back()->with('success', 'Thank you for reaching out! Our editorial team will get back to you within 24–48 hours.');
    }

    /**
     * Display Editorial & Legal Disclaimer.
     */
    public function disclaimer(): View
    {
        return view('pages.disclaimer');
    }
}
