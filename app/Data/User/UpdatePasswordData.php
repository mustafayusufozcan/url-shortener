<?php

namespace App\Data\User;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class UpdatePasswordData extends Data
{
    public function __construct(
        public string $currentPassword,
        public string $newPassword
    ) {}
}
