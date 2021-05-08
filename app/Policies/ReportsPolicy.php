<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportsPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can save report.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function save(User $user)
    {
        return $user->group->permissions->reports_save;
    }

    /**
     * Determine whether the user can view report.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->group->permissions->reports_view;
    }

    /**
     * Determine whether the user can manage the saved reports.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->reports_manage;
    }
}
