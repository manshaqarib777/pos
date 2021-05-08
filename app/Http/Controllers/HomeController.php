<?php
/**
 * This file implements Home Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  HomeController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Sale;
use App\Setting;
use App\UserActivity;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

/**
 * Controls the data flow into a Home object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  HomeController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class HomeController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display Home
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $per = $user->group->permissions;
        $logs = UserActivity::latest()->where('user_id', $user->id)->limit(20)->get();
        return view('home', compact(['logs', 'per']));
    }

    /**
     * Display Dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $this->authorize('dashboard', Setting::class);
        $payable = $this->_dailySale('payable', Date('m'), Date('Y'));
        $orders = $this->_dailySale('id', Date('m'), Date('Y'), true);
        $days = $this->_chartDays();
        return view('dashboard', compact(['days', 'payable', 'orders']));
    }

    /**
     * Quick mail from dashboard
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function quickMail(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'email' => 'required|email',
                'subject' => 'required|regex:/^[A-Za-z0-9 ]+$/',
                'message' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            ]
        );
        $validated['from'] = $this->bluePrints()->default_email;
        $validated['fromAlly'] = $this->bluePrints()->site_name;
        $validated['replyTo'] = Auth::user()->email;
        $validated['replyToAlly'] = Auth::user()->name;
        Mail::to($validated['email'])->send(new \App\Mail\QuickMail($validated));
        if (Mail::failures()) {
            event(
                new LogActivity(
                    $request->email,
                    trans('feed.failsToSendMail') . ' ' . $request->subject,
                    trans('feed.quickMail')
                )
            );
            return back()->with('warning', trans('feed.sorryPleaseTryAgainLatter'));
        }
        event(
            new LogActivity(
                $request->email,
                trans('feed.mailSentSuccessfully') . ' ' . $request->subject,
                trans('feed.quickMail')
            )
        );
        return back()->with('success', trans('feed.greatSuccessfullySent'));
    }

    /**
     * Generate Daily Sale
     *
     * @param mixed $key   The key
     * @param mixed $month The month
     * @param mixed $year  The year
     * @param bool  $all   All
     *
     * @return string
     */
    private function _dailySale($key, $month, $year, $all = null)
    {
        $saleData = [];
        for ($day = 1; $day < $this->_daysInMonth(); $day++) {
            $sales = Sale::whereYear('created_at', $year)
                ->whereMonth('created_at', (string) $month)
                ->whereDay('created_at', (string) $day);
            if ($all) {
                $saleData[$day] = $sales->count();
            } else {
                $saleData[$day] = $this->intoKillo($sales->sum($key));
            }
        }
        return implode(', ', $saleData);
    }

    /**
     * Gives Days
     *
     * @return string
     */
    private function _chartDays()
    {
        $days = [];
        for ($i = 1; $i < $this->_daysInMonth(); $i++) {
            $days[$i] = $i;
        }
        return implode(', ', $days);
    }

    /**
     * Days in Current month
     *
     * @return mixed
     */
    private function _daysInMonth()
    {
        return Carbon::now()->daysInMonth + 1;
    }
}
