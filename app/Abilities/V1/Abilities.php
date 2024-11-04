<?php

namespace App\Abilities\V1;

final class Abilities
{
    public const CREATE_URL = 'url:create';
    public const UPDATE_OWN_URL = 'url:own:update';
    public const DELETE_OWN_URL = 'url:own:delete';

    public static function getAbilities()
    {
        return [
            self::CREATE_URL,
            self::UPDATE_OWN_URL,
            self::DELETE_OWN_URL
        ];
    }
}
