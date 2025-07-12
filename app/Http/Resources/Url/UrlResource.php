<?php

namespace App\Http\Resources\Url;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original_url' => $this->url,
            'short_url' => config('app.url') . '/' . $this->code,
            $this->mergeWhen($this->visits_count, [
                'visits' => $this->visits_count
            ])
        ];
    }
}
