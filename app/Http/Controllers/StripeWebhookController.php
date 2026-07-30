<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $eventType = $payload['type'] ?? 'customer.subscription.updated';

        Log::info('Stripe webhook received: ' . $eventType, $payload);

        if (isset($payload['data']['object']['id'])) {
            $stripeSubId = $payload['data']['object']['id'];
            $subscription = Subscription::where('stripe_subscription_id', $stripeSubId)->first();

            if ($subscription) {
                if ($eventType === 'customer.subscription.deleted') {
                    $subscription->update(['status' => 'canceled']);
                } elseif ($eventType === 'invoice.payment_failed') {
                    $subscription->update(['status' => 'past_due']);
                } else {
                    $subscription->update(['status' => 'active']);
                }
            }
        }

        return response()->json(['status' => 'success', 'event' => $eventType]);
    }
}
