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
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if user can create a coffee.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
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
