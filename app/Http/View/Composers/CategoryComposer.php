<?php
namespace App\Http\View\Composers;

use App\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view)
    {
        $view->with('categories', Category::latest()->get());
    }
}
