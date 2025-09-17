<?php

use App\Http\Controllers\{AuthController, UrlController, UserController};
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('access_token', [AuthController::class, 'accessToken'])->name('access_token');
});

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::prefix('user/')->name('user.')->group(function () {
        Route::get('me', [UserController::class, 'me'])->name('me');
        Route::patch('password', [UserController::class, 'updatePassword'])->name('update_password');
    });

    Route::apiResource('urls', UrlController::class)->only(['index', 'show', 'destroy']);
    Route::post('urls/shorten', [UrlController::class, 'shorten'])->name('urls.shorten');
});
