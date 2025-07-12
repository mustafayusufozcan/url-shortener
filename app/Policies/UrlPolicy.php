<?php

namespace App\Policies;

use App\Models\Url\Url;
use App\Models\User;

class UrlPolicy
{
    public function view(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }

    public function delete(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;;
    }
}
