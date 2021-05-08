<?php

namespace App\Policies;

use App\User;
use App\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create expense vouchers.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->expense_add;
    }

    /**
     * Determine whether the user can manage the expense vouchers.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->expense_manage;
    }

    /**
     * Determine whether the user can view the expense summary.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function summary(User $user)
    {
        return $user->group->permissions->expense_summary;
    }
}
