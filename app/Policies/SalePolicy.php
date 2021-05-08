<?php

namespace App\Policies;

use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create sale.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->sale_create;
    }

    /**
     * Determine whether the user can manage the sale.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->sale_manage;
    }

    /**
     * Determine whether the user can view the sale summary chart.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function summary(User $user)
    {
        return $user->group->permissions->sale_summary;
    }


    /**
     * Determine whether the user can generate the sale report.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function report(User $user)
    {
        return $user->group->permissions->sale_report;
    }
}
