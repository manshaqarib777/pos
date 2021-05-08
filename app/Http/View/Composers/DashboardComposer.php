<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class DashboardComposer
{
    public function compose(View $view)
    {
        $dashboard = [
        'products'   => \App\Product::latest()->get()->count(),
        'Items'      => \App\Product::sum('qty'),
        'sales'      => \App\Sale::latest()->get()->count(),
        'refunds'    => \App\Refund::latest()->get()->count(),
        'customers'  => \App\Customer::latest()->get()->count(),
        'suppliers'  => \App\Supplier::latest()->get()->count(),
        'purchases'  => \App\Purchase::latest()->get()->count(),
        'expenses'   => \App\Expense::latest()->get()->count(),
        'warehouses' => \App\Warehouse::latest()->get()->count(),
        'users'      => \App\User::latest()->get()->count(),
        'opendChapters'  => \App\Chapter::where('status', 1)->get(),
        'lastSales'  => \App\Sale::latest()->take(10)->get(),
        'lastRefunds'  => \App\Refund::latest()->take(10)->get()];
        $view->with('dashboard', $dashboard);
    }
}
