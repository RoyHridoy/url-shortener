<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    protected $policy;

    public function isAble($ability, $targetModel): bool
    {
        try {
            Gate::authorize($ability, [$targetModel, $this->policy]);
            return true;
        } catch (AuthorizationException $exception) {
            return false;
        }
    }
}
