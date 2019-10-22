<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

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

    /**
     * Check if a user is allowed to update their own account
     * on the admin dashboard.
     *
     * @param \App\Models\User  $authUser
     * @param \App\Models\User  $requestUser
     */
    public function updateSelf(User $authUser, User $requestUser)
    {
        return !$authUser->is($requestUser);
    }
}
