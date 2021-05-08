<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckForOpenedChapter
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
        if ($request->method() == 'POST'
            && User::find($request->user)->chapters->where('status', 1)->all()
        ) {
            return back()->with('info', trans('mid.thisUserHasAlreadyOpenedChapter'));
        }

        if (Auth::user()->id < 2) {
            return $next($request);
        }

        if ($request->method() == 'GET'
            && auth()->user()->chapters->where('status', 1)->all()
        ) {
            return redirect(route('pos.index'))
            ->with('message', trans('mid.dontPlayYouAlreadyOpenedChapter'));
        }

        return $next($request);
    }
}
