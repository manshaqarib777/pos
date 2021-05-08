<?php

namespace App\Http\Middleware;

use App\Events\LogActivity;
use App\Setting;
use Closure;

class AppDemoCheck
{
    public function handle($request, Closure $next)
    {
        if (Setting::find(1)->demo === 'inactive') {
            return $next($request);
        }
        if (in_array(\Request::segment(1), ['group', 'permission']) && \Request::segment(2) > 7) {
            return $next($request);
        }

        if (\Request::segment(1) == 'user' && \Request::segment(2) > 5) {
            return $next($request);
        }

        event(
            new LogActivity(
                'Link: ' . \Request::url(),
                ' Attempted to perform disabled action while demo mode',
                'Demo Mode'
            )
        );
        if ($request->ajax()) {
            return response()->json(
                ['type' => 'warning', 'message' => 'Disable in demo mode'],
                200
            );
        }
        return redirect(route('home'))
            ->with('message', 'Disable in demo mode!');
    }
}
