<?php

namespace App\Data\Url;

use Spatie\LaravelData\Data;

class ShortenUrlData extends Data
{
    public function __construct(
        public string $url
    ) {}
}
