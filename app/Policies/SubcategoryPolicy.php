<?php

namespace App\Policies;

use App\User;
use App\Subcategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubcategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create subcategories.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->group->permissions->subcategory_add;
    }

    /**
     * Determine whether the user can manage the subcategory.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->subcategory_manage;
    }
}
