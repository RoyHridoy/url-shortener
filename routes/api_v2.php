<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UrlController;
use App\Http\Controllers\Api\V2\UrlController as UrlControllerV2;
use App\Http\Controllers\Api\V1\UserProfileController;
use Illuminate\Support\Facades\Route;

// All Version 1.0 Features Exists
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', UserProfileController::class)->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::apiResource('urls', UrlControllerV2::class)->except('update');

    // V2.0 Customize Url
    // Route::patch('urls/{url}', [UrlControllerV2::class, 'update'])->name('urls.update');
});
