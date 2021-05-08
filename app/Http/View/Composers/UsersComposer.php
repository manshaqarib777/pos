<?php
namespace App\Http\View\Composers;

use App\User;
use Illuminate\View\View;

class UsersComposer
{
    public function compose(View $view)
    {
        $view->with('users', User::latest()->get());
    }
}
