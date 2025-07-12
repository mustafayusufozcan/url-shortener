<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasResponse
{
    public function errorResponse(?string $message = null, null|array|string $data = null, int $status = 422): JsonResponse
    {
        return $this->response($message, $data, $status);
    }

    public function successResponse(?string $message = null, null|array|string $data = null, int $status = 200): JsonResponse
    {
        return $this->response($message, $data, $status);
    }

    public function noContentResponse(): JsonResponse
    {
        return $this->response(null, null, 204);
    }

    private function response(?string $message = null, null|array|string $data = null, int $status): JsonResponse

    {
        return response()->json(
            array_merge(
                is_array($data) ? $data : (!empty($data) ? ['data' => $data] : []),
                !empty($message) ? ['message' => $message] : []
            ),
            $status
        );
    }
}
