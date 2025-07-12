<?php

namespace App\Data\Url;

use Spatie\LaravelData\Data;

class RedirectUrlData extends Data
{
    public function __construct(
        public string $code,
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
        public ?string $referer = null
    ) {}
}
