<?php

namespace App\Services;

use App\Data\User\UpdatePasswordData;
use App\Exceptions\User\InvalidPasswordException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @return User
     */
    public function getUser(): User
    {
        return Auth::user();
    }

    /**
     * @param UpdatePasswordData $data
     * 
     * @return bool
     * @throws InvalidPasswordException
     */
    public function updatePassword(UpdatePasswordData $data): bool
    {
        $user = $this->getUser();

        if (!Hash::check($data->currentPassword, $user->password)) {
            throw new InvalidPasswordException;
        }

        return $user->update([
            'password' => $data->newPassword
        ]);
    }
}
