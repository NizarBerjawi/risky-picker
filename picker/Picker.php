<?php

namespace Picker;

use Picker\User;
use Illuminate\Support\Collection;

class Picker
{
    /**
     * Attempt to pick a user from a collection of users
     *
     * @return User $user
     * @throws \App\Exceptions\UnluckyUserNotFoundException
     */
    public static function pick(Collection $users)
    {
        $pickableUsers = $users->filter(function($user) {
            return $user->canBePickedForCoffee();
        });

        if ($pickableUsers->isEmpty()) {
            throw new UnluckyUserNotFoundException('Could not pick a user');
        }

        return $pickableUsers->random();

    }
}
