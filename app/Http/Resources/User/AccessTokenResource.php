<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'Bearer',
            'expires_in' => (int) $this->expiresAt->diffInSeconds(now(), true),
            'expires_at' => $this->expiresAt->timestamp
        ];
    }
}
