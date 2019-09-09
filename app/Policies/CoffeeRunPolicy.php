<?php

namespace App\Policies;

use App\Models\{CoffeeRun, User, UserCoffee};
use Illuminate\Auth\Access\HandlesAuthorization;

class CoffeeRunPolicy
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
     * Determine if the given coffee run can be modified by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoffeeRun  $run
     * @return bool
     */
    public function busy(User $user, CoffeeRun $run)
    {
        return $user->is($run->user);
    }

    /**
     * Determine if the given coffee run can be modified by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoffeeRun  $run
     * @param  \App\Models\UserCoffee  $coffee
     * @return bool
     */
    public function remove(User $user, CoffeeRun $run, UserCoffee $coffee)
    {
        return $user->is($run->user) || $user->is($coffee->user);
    }

    /**
     * Determine if the user is allowed to volunteer for a given coffee run.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoffeeRun  $run
     * @return bool
     */
    public function volunteer(User $user, CoffeeRun $run)
    {
        return true;
    }

    /**
     * Determine if the user is allowed to re-select a coffee run
     * user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CoffeeRun  $run
     * @return bool
     */
    public function pick(User $user, CoffeeRun $run)
    {
        return $user->isNot($run->user) &&
               $user->isAdmin() &&
               !$run->volunteerRequested() &&
               $run->notExpired() &&
               $run->notLocked();
    }
}
