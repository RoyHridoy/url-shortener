<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }
}
