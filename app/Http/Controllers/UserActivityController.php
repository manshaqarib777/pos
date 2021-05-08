<?php

/**
 * This file implements User Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  UserActivity
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\User;
use App\UserActivity;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a User object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  UserActivity
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class UserActivityController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('demoCheck')->except('index');
    }

    /**
     * Load All logs
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', UserActivity::class);
        $logs = UserActivity::latest()->paginate(22);
        return view('setting.logs', compact('logs'));
    }

    /**
     * Updates the given request.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->authorize('manage', UserActivity::class);
        if ($request->clear_log) {
            UserActivity::where('user_id', $request->user)->delete();
        }
        $user = User::find($request->user);
        $user->update(['log' => $request->log_action ?? 0]);

        return back()->with('success', trans('feed.operationSuccessful'));
    }

    /**
     * Clears the given request.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear(Request $request)
    {
        $this->authorize('manage', UserActivity::class);
        if ($request->agree) {
            UserActivity::latest()->delete();
            return back()->with('success', trans('feed.alllogsClearedSuccessfully'));
        }
    }
}
