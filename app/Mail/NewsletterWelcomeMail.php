<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Welcome to Daily AI World Executive Briefing 🌐',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-welcome',
            with: [
                'email' => $this->subscriber->email,
                'edition' => $this->subscriber->edition ?? 'Daily Executive Briefing',
                'siteUrl' => config('app.url', 'https://dailyaiworld.com'),
                'appName' => config('app.name', 'Daily AI World'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
