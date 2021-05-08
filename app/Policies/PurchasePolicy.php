<?php

namespace App\Policies;

use App\User;
use App\Purchase;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create purchase orders.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->purchase_add;
    }

    /**
     * Determine whether the user can manage the purchases  orders.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->purchase_manage;
    }

    /**
     * Determine whether the user can view the purchases orders summary.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function summary(User $user)
    {
        return $user->group->permissions->purchase_summary;
    }

    /**
     * Determine whether the user can generate the orders purchase.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function report(User $user)
    {
        return $user->group->permissions->purchase_report;
    }
}
