<?php

use App\Http\Controllers\Api\V1\RedirectController;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Route;

Route::get('/{url:shortUrl}', RedirectController::class)->name('shortenUrl');

// Api Version 1.0 Documentation
Scramble::registerUiRoute(path: 'docs/v1', api: 'v1');

// Api Version 2.0 Documentation
Scramble::registerUiRoute(path: 'docs/v2', api: 'v2');
