<?php

namespace App\DTOs;

class NewsletterData
{
    public function __construct(
        public string $email,
        public string $edition = 'Daily Executive Briefing'
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'edition' => $this->edition,
            'status' => 'active',
        ];
    }
}
