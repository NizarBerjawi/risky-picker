<?php

namespace Picker\Cup\Policies;

use Picker\{Cup, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CupPolicy
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
     * Determine if the given cup can be updated by the user.
     *
     * @param  User  $user
     * @param  Cup  $cup
     * @return bool
     */
    public function update(User $user, Cup $cup)
    {
        return $user->is($cup->user);
    }

    /**
     * Determine if the given cup can be deleted by the user.
     *
     * @param  User  $user
     * @param  Cup  $cup
     * @return bool
     */
    public function delete(User $user, Cup $cup)
    {
        return $user->is($cup->user);
    }
}
