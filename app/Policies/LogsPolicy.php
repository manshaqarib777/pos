<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view logs.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->group->permissions->logs_view;
    }

    /**
     * Determine whether the user can manage the logs.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->logs_manage;
    }
}
