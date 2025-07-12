<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $e, Request $request) {
            $headers = $errors = [];
            $statusCode = 422;

            if ($e instanceof HttpExceptionInterface) {
                $statusCode = $e->getStatusCode();
                $headers = $e->getHeaders();
            } elseif (method_exists($e, 'getCode') && is_numeric($e->getCode()) && $e->getCode() >= 100 && $e->getCode() <= 599) {
                $statusCode = $e->getCode();
            }

            if ($e instanceof ValidationException) {
                $errors = [
                    'errors' => $e->errors(),
                ];
            }

            if ($request->expectsJson()) {
                return response()->json(array_merge([
                    "message" => $e->getMessage()
                ], $errors), $statusCode, $headers);
            }
        });
    })->create();
