<?php

namespace App\Models\Url;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlVisit extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'url_id',
        'ip_address',
        'user_agent',
        'referer',
    ];

    public function url(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
