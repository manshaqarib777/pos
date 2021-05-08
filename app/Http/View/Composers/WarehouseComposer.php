<?php

namespace App\Http\View\Composers;

use App\Warehouse;
use Illuminate\View\View;

class WarehouseComposer
{
    public function compose(View $view)
    {
        $view->with('warehouses', Warehouse::latest()->get());
    }
}
