<?php

use App\Http\Controllers\Api\V1\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/{url:shortUrl}', RedirectController::class)->name('shortenUrl');
