<?php

namespace App\Http\Controllers;

use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\AccessTokenResource;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = RegisterData::from($request->validated());
        $user = $this->authService->register($data);

        return $this->successResponse('Successfully registered.', [
            'user' => new UserResource($user)
        ], status: 201);
    }

    public function accessToken(LoginRequest $request): JsonResponse
    {
        $data = LoginData::from($request->validated());
        $accessToken = $this->authService->createAccessToken($data);

        return $this->successResponse('Successfully logged in.', [
            'user' => new UserResource($accessToken->user),
            'token' => new AccessTokenResource($accessToken),
        ]);
    }
}
