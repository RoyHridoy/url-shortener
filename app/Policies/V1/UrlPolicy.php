<?php

namespace App\Policies\V1;

use App\Abilities\V1\Abilities;
use App\Models\Url;
use App\Models\User;

class UrlPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Url $url): bool
    {
        return $url->users->contains($user);
    }

    /**
     * Determine whether the user can create an url.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan(Abilities::CREATE_URL);
    }

    /**
     * Determine whether the user can create an url for Version 2.
     */
    public function createV2(User $user): bool
    {
        return $user->tokenCan(Abilities::CREATE_URL) && $user->urls()->count() < config('app.url_creation_max_limit');
    }

    /**
     * Determine whether the user can update the url.
     */
    public function update(User $user, Url $url): bool
    {
        return $user->tokenCan(Abilities::UPDATE_OWN_URL) && $url->users->contains($user);
    }

    /**
     * Determine whether the user can delete the url.
     */
    public function delete(User $user, Url $url): bool
    {
        return $user->tokenCan(Abilities::DELETE_OWN_URL) && $url->users->contains($user->id);
    }
}
