<?php

namespace App\Policies;

use App\User;
use App\Tax;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create tax.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->tax_add;
    }

    /**
     * Determine whether the user can manage the tax.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->tax_manage;
    }

    /**
     * Determine whether the user can view the tax summary chart.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function summary(User $user)
    {
        return $user->group->permissions->tax_summary;
    }

    /**
     * Determine whether the user can generate the tax report.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function report(User $user)
    {
        return $user->group->permissions->tax_report;
    }
}
