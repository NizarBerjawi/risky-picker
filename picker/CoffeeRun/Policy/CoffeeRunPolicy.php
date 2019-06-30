<?php

namespace Picker\CoffeeRun\Policy;

use Picker\{CoffeeRun, User};
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
     * @param  User  $user
     * @param  CoffeRun  $run
     * @return bool
     */
    public function busy(User $user, CoffeeRun $run)
    {
        return $user->is($run->user);
    }

    /**
     * Determine if the user is allowed to volunteer for a given coffee run.
     *
     * @param  User  $user
     * @param  CoffeRun  $run
     * @return bool
     */
    public function volunteer(User $user, CoffeeRun $run)
    {
        return $user->isNot($run->user) && $run->needsVolunteer();
    }
}
