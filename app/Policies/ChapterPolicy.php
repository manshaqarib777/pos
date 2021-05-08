<?php
namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can open chapter.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function open(User $user)
    {
        return $user->group->permissions->chapter_open;
    }

    /**
     * Determine whether the user can close chapter.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function close(User $user)
    {
        return $user->group->permissions->chapter_close;
    }

    /**
     * Determine whether the user can manage the chapter.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->group->permissions->chapter_manage;
    }
}
