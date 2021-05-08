<?php
namespace App\Http\View\Composers;

use App\Tax;
use Illuminate\View\View;

class TaxComposer
{
    public function compose(View $view)
    {
        $view->with('taxes', Tax::latest()->get());
    }
}
