<?php

namespace App\Listeners;

use App\Events\Url\Visited;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordVisit implements ShouldQueue
{
    public $queue = 'visits';
    
    public function handle(Visited $event): void
    {
        $event->url->visits()->create([
            'ip_address' => $event->ipAddress,
            'user_agent' => $event->userAgent,
            'referer' => $event->referer,
        ]);
    }
}
