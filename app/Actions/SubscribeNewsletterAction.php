<?php

namespace App\Actions;

use App\DTOs\NewsletterData;
use App\Models\NewsletterSubscriber;

class SubscribeNewsletterAction
{
    public function execute(NewsletterData $data): NewsletterSubscriber
    {
        return NewsletterSubscriber::firstOrCreate(
            ['email' => $data->email],
            $data->toArray()
        );
    }
}
