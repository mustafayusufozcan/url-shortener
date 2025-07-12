<?php

namespace App\Services;

use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Data\Auth\TokenData;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param LoginData $data
     * 
     * @return User
     * @throws InvalidCredentialsException
     */
    private function authenticate(LoginData $data): User
    {
        $user = User::where('email', $data->email)->first();
        if (!$user || !Hash::check($data->password, $user->password)) {
            throw new InvalidCredentialsException;
        }

        return $user;
    }

    /**
     * @param RegisterData $data
     * 
     * @return User
     */
    public function register(RegisterData $data): User
    {
        return User::create([
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }

    /**
     * @param LoginData $data
     * 
     * @return TokenData
     */
    public function createAccessToken(LoginData $data): TokenData
    {
        $user = $this->authenticate($data);
        $expiresAt = now()->addHours(4);
        $token = $user->createToken('auth_token', expiresAt: $expiresAt);

        return new TokenData(
            $token->plainTextToken,
            $expiresAt,
            $user
        );
    }
}
