<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create product.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->product_add;
    }

    /**
     * Determine whether the user can manage the product.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->product_manage;
    }

    /**
     * Determine whether the user can view the inventory report.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function report(User $user)
    {
        return $user->group->permissions->product_inventory;
    }
}
