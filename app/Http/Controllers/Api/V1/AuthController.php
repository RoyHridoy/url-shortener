<?php

namespace App\Http\Controllers\Api\V1;

use App\Abilities\V1\Abilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok('Authenticated', [
            'token' => $user->createToken(
                'token-'. $user->email,
                Abilities::getAbilities(),
                now()->addWeek()
            )->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Successfully Logged Out');
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->mappedAttributes());
        return $this->ok('register successfully', new UserResource($user));
    }
}
