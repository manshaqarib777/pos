<?php

namespace App\Http\Middleware;

use App\Chapter;
use App\Payment;
use Closure;
use Illuminate\Support\Facades\Auth;

class RegisterForPointOfSale
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
        if (Payment::where('state', '1')->get()->count() < 1) {
            return redirect(route('payment.create'))
                ->with('info', trans('mid.addNewPaymentGateway'))
                ->with('warning', trans('mid.activatePaymentGateway'));
        }

        if (Auth::user()->chapters->where('status', '1')->all()) {
            return $next($request);
        }
        return redirect(route('chapter.create'))
                    ->with('warning', trans('mid.didNotOpenSaleRegister'));
    }
}
