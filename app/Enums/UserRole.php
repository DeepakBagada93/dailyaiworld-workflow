<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'Admin';
    case Editor = 'Editor';
    case Author = 'Author';
    case Subscriber = 'Subscriber';
    case Guest = 'Guest';

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isEditor(): bool
    {
        return $this === self::Admin || $this === self::Editor;
    }

    public function isAuthor(): bool
    {
        return $this === self::Admin || $this === self::Editor || $this === self::Author;
    }
}
