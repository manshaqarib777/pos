<?php
namespace App\Http\View\Composers;

use App\Group;
use Illuminate\View\View;

class GroupsComposer
{
    public function compose(View $view)
    {
        $view->with('groups', Group::skip(2)->take(PHP_INT_MAX)->get());
    }
}
