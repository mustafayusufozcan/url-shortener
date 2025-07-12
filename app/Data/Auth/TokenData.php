<?php

namespace App\Data\Auth;

use App\Models\User;
use DateTimeInterface;
use Spatie\LaravelData\Data;

class TokenData extends Data
{
    public function __construct(
        public string $token,
        public DateTimeInterface $expiresAt,
        public User $user
    ) {}
}
