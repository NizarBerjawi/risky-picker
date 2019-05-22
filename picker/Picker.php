<?php

namespace Picker;

use Picker\User;
use Illuminate\Support\Collection;
use App\Exceptions\UnluckyUserNotFoundException;

class Picker
{
    /**
     * Attempt to pick a user
     *
     * @return Collection $user
     * @throws UnluckyUserNotFoundException
     */
    public static function pick(Collection $users) : User
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
