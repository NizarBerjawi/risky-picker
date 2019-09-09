<?php

namespace App\Policies;

use App\Models\{User, Coffee, UserCoffee};
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCoffeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before(User $user)
    {
        //
    }

    /**
     * Determine if user can create a coffee.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // If the user is trying to create a standard coffee,
        // then let them
        if (!request()->route('run')) {
            return true;
        }

        // Check if the person creating the adhoc coffee, is owner
        // of the original coffee.
        return $user->userCoffees()
                    ->where('id', request()->query('coffee_id'))
                    ->exists();
    }

    /**
     * Determine if the given coffee can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoffee  $userCoffee
     * @return bool
     */
    public function update(User $user, UserCoffee $userCoffee)
    {
        return $user->is($userCoffee->user);
    }

    /**
     * Determine if the given coffee can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\UserCoffee  $userCoffee
     * @return bool
     */
    public function delete(User $user, UserCoffee $userCoffee)
    {
        return $user->is($userCoffee->user);
    }
}
