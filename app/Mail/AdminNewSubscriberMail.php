<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsletterSubscriber $subscriber,
        public int $totalSubscribers = 0
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: '🎉 New Newsletter Subscriber: ' . $this->subscriber->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-new-subscriber',
            with: [
                'email' => $this->subscriber->email,
                'edition' => $this->subscriber->edition ?? 'Daily Executive Briefing',
                'subscribedAt' => $this->subscriber->created_at ? $this->subscriber->created_at->format('M d, Y H:i T') : now()->format('M d, Y H:i T'),
                'totalSubscribers' => $this->totalSubscribers,
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
