<?php

namespace Picker\Coffee\Policies;

use Picker\{Coffee, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CoffeePolicy
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
}
