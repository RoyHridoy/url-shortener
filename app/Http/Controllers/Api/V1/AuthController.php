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

    /**
     * @unauthenticated
     * Authenticate the user and issue a new access token.
     *
     * Attempts to log in the user with the provided credentials. If successful,
     * generates a new personal access token with specific abilities, valid for one week.
     * Returns an error response if the credentials are invalid.
     *
     * @param LoginUserRequest $request The validated login request containing user credentials.
     * @return \Illuminate\Http\JsonResponse JSON response with authentication status and token if successful,
     * or error response if authentication fails.
     */
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

    /**
     * Log the user out by revoking the current access token.
     *
     * Deletes the current access token associated with the authenticated user, effectively logging them out.
     *
     * @param Request $request The request instance containing the user's authentication context.
     * @return \Illuminate\Http\JsonResponse JSON response indicating successful logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Successfully Logged Out');
    }

    /**
     * @unauthenticated
     * Register a new user.
     *
     * Creates a new user account with the provided registration data and returns a success response
     * along with the new user's details.
     *
     * @param RegisterUserRequest $request The validated request containing user registration data.
     * @return \Illuminate\Http\JsonResponse JSON response indicating successful registration
     * and including the newly created user resource.
     */
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->mappedAttributes());
        return $this->ok('register successfully', new UserResource($user));
    }
}
