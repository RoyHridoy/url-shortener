<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UrlController;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'register'])->name('logout')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->apiResource('urls', UrlController::class);
