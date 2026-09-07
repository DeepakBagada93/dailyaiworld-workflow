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
        if (!checkdnsrr($domain, "MX")) {
            abort(422, 'Invalid email domain with no active mail exchange (MX) records.');
        }

        // 2. Reject obvious spam scraping patterns
        $userPart = substr($email, 0, strpos($email, '@'));
        if ($domain === 'azharhs.org' || preg_match('/[a-z]{5,}[0-9][a-z0-9]{4,}$/', $userPart)) {
            abort(422, 'Suspicious email address pattern detected.');
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
