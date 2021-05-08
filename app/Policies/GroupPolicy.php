<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the User Permssion Groups.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->group_add;
    }
    /**
     * Determine whether the user can manage the User Permission Groups.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->group_manage;
    }

    /**
     * Determine whether the user can request for  the Dedicated .
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function newRequest(User $user)
    {
        return $user->group->permissions->group_request;
    }
    /**
     * Determine whether the user can manage the Dedicated Permission request.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manageRequest(User $user)
    {
        return $user->group->permissions->group_request_manage;
    }
}
