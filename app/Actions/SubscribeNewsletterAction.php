<?php

namespace App\Actions;

use App\DTOs\NewsletterData;
use App\Mail\AdminNewSubscriberMail;
use App\Mail\NewsletterWelcomeMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscribeNewsletterAction
{
    public function execute(NewsletterData $data): NewsletterSubscriber
    {
        $email = trim(strtolower($data->email));
        $domain = substr(strrchr($email, "@"), 1);

        // 1. Check DNS MX records
        if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
            abort(422, 'Invalid email domain with no active mail exchange (MX) records.');
        }

        // 2. Reject disposable, burner, and spam scraping domains
        $disposableDomains = [
            'smaqt.com', 'mailinator.com', 'tempmail.com', '10minutemail.com',
            'guerrillamail.com', 'sharklasers.com', 'yopmail.com', 'trashmail.com',
            'dispostable.com', 'getnada.com', 'inboxkitten.com', 'burnermail.io',
            'dropmail.me', 'fakemailgenerator.com', 'mohmal.com', 'crazymailing.com',
            'temp-mail.org', 'mytemp.email', 'throwawaymail.com', 'emailondeck.com',
            'generator.email', 'azharhs.org', 'azhlyce.org', 'azhacd.org', 'immenseignite.info'
        ];

        $userPart = substr($email, 0, strpos($email, '@'));
        if (in_array($domain, $disposableDomains) || str_starts_with($domain, 'azh') || str_ends_with($domain, '.info')) {
            abort(422, 'Disposable, temporary, or suspicious email domains are not permitted.');
        }

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $email],
            $data->toArray()
        );

        // Ensure status is active
        if ($subscriber->status !== 'active') {
            $subscriber->update(['status' => 'active']);
        }

        // Send welcome email & admin notification
        $this->sendSubscriptionEmails($subscriber);

        return $subscriber;
    }

    public function sendSubscriptionEmails(NewsletterSubscriber $subscriber): void
    {
        try {
            // 1. Send Welcome Email to subscriber
            Mail::to($subscriber->email)->send(new NewsletterWelcomeMail($subscriber));

            // 2. Send Alert Email to Admin
            $adminEmail = config('mail.admin_address') ?: config('mail.from.address') ?: env('ADMIN_EMAIL', 'editor@dailyaiworld.com');
            if ($adminEmail) {
                $totalSubscribers = NewsletterSubscriber::where('status', 'active')->count();
                Mail::to($adminEmail)->send(new AdminNewSubscriberMail($subscriber, $totalSubscribers));
            }
        } catch (\Throwable $e) {
            Log::error('Newsletter subscription email dispatch error: ' . $e->getMessage(), [
                'subscriber' => $subscriber->email,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
