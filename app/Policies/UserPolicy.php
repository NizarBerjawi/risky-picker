<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine if the given account can be updated by the user.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $requestUser
     * 
     * @return bool
     */
    public function update(User $authUser, User $requestUser)
    {
        return $authUser->is($requestUser);
    }
}
