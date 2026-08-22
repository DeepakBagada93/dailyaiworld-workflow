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
        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $data->email],
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
