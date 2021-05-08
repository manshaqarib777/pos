<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can add new user.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->user_create;
    }

    /**
     * Determine whether the user can manage the users.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->user_manage;
    }

    /**
     * Determine whether the user can edit the user info.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function edit(User $user)
    {
        return $user->group->permissions->user_edit;
    }
}
