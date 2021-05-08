<?php
namespace App\Http\View\Composers;

use App\Supplier;
use Illuminate\View\View;

class SupplierComposer
{
    public function compose(View $view)
    {
        $view->with('suppliers', Supplier::latest()->get());
    }
}
