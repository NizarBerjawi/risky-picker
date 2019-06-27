<?php

namespace Picker\UserCoffee\Policies;

use Picker\{User, Coffee, UserCoffee};
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
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        if (!request()->get('is_adhoc', false)) {
            return true;
        }

        // Check if the person creating the adhoc coffee, is owner
        // of the original coffee.
        return $user->userCoffees()
                    ->withAdhoc()
                    ->where('id', request()->get('id'))
                    ->exists();
    }

    /**
     * Determine if the given coffee can be updated by the user.
     *
     * @param  User  $user
     * @param  UserCoffee  $userCoffee
     * @return bool
     */
    public function update(User $user, UserCoffee $userCoffee)
    {
        return $user->is($userCoffee->user);
    }

    /**
     * Determine if the given coffee can be deleted by the user.
     *
     * @param  User  $user
     * @param  UserCoffee  $userCoffee
     * @return bool
     */
    public function delete(User $user, UserCoffee $userCoffee)
    {
        return $user->is($userCoffee->user);
    }
}
