<?php

namespace App\Policies\V1;

use App\Abilities\V1\Abilities;
use App\Models\Url;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UrlPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Url $url): bool
    {
        return $url->user()->is($user);
    }

    /**
     * Determine whether the user can create an url.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan(Abilities::CREATE_URL);
    }

    /**
     * Determine whether the user can update the url.
     */
    public function update(User $user, Url $url): bool
    {
        return $user->tokenCan(Abilities::UPDATE_OWN_URL) && $url->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the url.
     */
    public function delete(User $user, Url $url): bool
    {
        return $user->tokenCan(Abilities::DELETE_OWN_URL) && $url->user_id === $user->id;
    }
}
