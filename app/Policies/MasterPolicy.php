<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the setting.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->group->permissions->setting_view;
    }

    /**
     * Determine whether the user can take,remove & restore database backup.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function backup(User $user)
    {
        return $user->group->permissions->setting_backup;
    }

    /**
     * Determine whether the user can update the general setting.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function general(User $user)
    {
        return $user->group->permissions->setting_general;
    }


    /**
     * Determine whether the user can update logo.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function logo(User $user)
    {
        return $user->group->permissions->setting_logo;
    }

    /**
     * Determine whether the user can update mail config.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function mail(User $user)
    {
        return $user->group->permissions->setting_mail;
    }

    /**
     * Determine whether the user can update product default.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function productDefaults(User $user)
    {
        return $user->group->permissions->setting_product_default;
    }

    /**
     * Determine whether the user can update impects.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function impects(User $user)
    {
        return $user->group->permissions->setting_impects;
    }

    /**
     * Determine whether the user can update pos config.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function pos(User $user)
    {
        return $user->group->permissions->setting_pos;
    }


    /**
     * Determine whether the user can quick mail.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function quickMail(User $user)
    {
        return $user->group->permissions->setting_quick_mail;
    }


    /**
     * Determine whether the user can vist dashboard.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function dashboard(User $user)
    {
        return $user->group->permissions->setting_dashboard;
    }
}
