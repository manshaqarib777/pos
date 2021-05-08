<?php

namespace App\Policies;

use App\User;
use App\Refund;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefundPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create refund.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->refund_create;
    }

    /**
     * Determine whether the user can manage the refund.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->refund_manage;
    }

    /**
     * Determine whether the user can view the refund summary chart.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function summary(User $user)
    {
        return $user->group->permissions->refund_summary;
    }
}
