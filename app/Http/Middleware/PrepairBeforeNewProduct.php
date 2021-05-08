<?php
namespace App\Http\Middleware;

use App\Category;
use App\Supplier;
use App\Warehouse;
use Closure;

class PrepairBeforeNewProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (count(Warehouse::latest()->get()) < 1) {
            return redirect(route('warehouse.create'))
            ->with(
                'warning',
                trans('mid.prepairBeforeNPStep1')
            );
        }
        if (count(Supplier::latest()->get()) < 1) {
            return redirect(route('supplier.create'))
            ->with(
                'warning',
                trans('mid.prepairBeforeNPStep2')
            );
        }
        if (count(Category::latest()->get())< 1) {
            return redirect(route('category.create'))
                ->with(
                    'info',
                    trans('mid.prepairBeforeNPStep3')
                )
                ->with(
                    'warning',
                    trans('mid.prepairBeforeNPStep4')
                );
        }
        return $next($request);
    }
}
