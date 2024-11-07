<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display the authenticated user's information.
     *
     * This method returns the current authenticated user's details
     * wrapped in a `UserResource` instance.
     *
     * @return UserResource JSON resource containing the authenticated user's data.
     */
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }
}
