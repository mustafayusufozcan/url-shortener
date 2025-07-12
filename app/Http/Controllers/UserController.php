<?php

namespace App\Http\Controllers;

use App\Data\User\UpdatePasswordData;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\User\UserDetailResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function me(): JsonResponse
    {
        $user = $this->userService->getUser();

        return $this->successResponse(data: [
            'user' => new UserDetailResource($user)
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $data = UpdatePasswordData::from($request->validated());
        $this->userService->updatePassword($data);

        return $this->successResponse(__('Password updated successfully'));
    }
}
