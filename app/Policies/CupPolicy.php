<?php

namespace App\Policies;

use App\Models\{Cup, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CupPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cup  $cup
     * 
     * @return bool
     */
    public function update(User $user, Cup $cup)
    {
        return $user->is($cup->user);
    }

    /**
     * Determine if the given cup can be deleted by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cup  $cup
     * 
     * @return bool
     */
    public function delete(User $user, Cup $cup)
    {
        return $user->is($cup->user);
    }
}
