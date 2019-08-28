<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Picker
{
    /**
     * Attempt to pick a user from a collection of users
     *
     * @return \App\Models\User
     * @throws \App\Exceptions\UnluckyUserNotFoundException
     */
    public static function pick(Collection $users)
    {
        while($users->isNotEmpty()) {
            $user = $users->random();

            if ($user->canBePickedForCoffee()) {
                return $user;
            }

            $users->pull($users->search($user));
        }

        throw new UnluckyUserNotFoundException('Could not pick a user');
    }
}
