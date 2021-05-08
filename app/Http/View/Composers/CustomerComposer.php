<?php

namespace App\Http\View\Composers;

use App\Customer;
use Illuminate\View\View;

class CustomerComposer
{
    public function compose(View $view)
    {
        $view->with('customers', Customer::latest()->get());
    }
}
