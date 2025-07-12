<?php

namespace App\Events\Url;

use App\Models\Url\Url;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Visited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Url $url,
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
        public ?string $referer = null,
    ) {}
}
