<?php
/**
 * This file implements Purchase Report Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  PurchaseReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Purchase Report object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  PurchaseReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PurchaseReportController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    Generate yearly details
     *
    @return \Illuminate\View\View
     */
    public function detail()
    {
        $this->authorize('summary', Purchase::class);
        $data = $this->_purchaseSummery();
        $sum['orders'] = $this->_countPurchaseOrders();
        $sum['amount'] = $this->_calculate('total_payment');
        $sum['shipping'] = $this->_calculate('shipping');
        $sum['discount'] = $this->_calculate('discount_amount');
        event(
            new LogActivity(
                trans('feed.purchase'),
                trans('feed.annualCostingChart'),
                trans('feed.chart')
            )
        );
        return view('finance.purchase.detail', compact(['data', 'sum']));
    }

    /**
     * Over all summary
     *
     * @return Array
     */
    private function _purchaseSummery()
    {
        //Fetch all purchase orders
        $purchase = Purchase::latest()->get();
        //By Default
        $data = [
            'orders' => 0,
            'amount' => 0,
            'shipping' => 0,
            'qty' => 0,
            'discount' => 0,
        ];
        //Count total
        $data['orders'] = $purchase->count();
        //Sum up data
        foreach ($purchase as $order) {
            $data['amount'] += $order->total_payment;
            $data['shipping'] += $order->shipping;
            $data['qty'] += $order->total_qty;
            $data['discount'] += $order->discount_amount;
        }
        return $data;
    }

    /**
     * Calculate order values monthly
     *
     * @param String $key The key
     *
     * @return String
     */
    private function _calculate($key)
    {
        $data = [];
        for ($i = 1; $i < 13; $i++) {
            $data[$i] = $this->intoKillo(
                $this->_sumUp($key, (string) $i, Date('Y'))
            );
        }
        return implode(', ', $data);
    }

    /**
     * Counts the number of purchase orders monthly.
     *
     * @return String.
     */
    private function _countPurchaseOrders()
    {
        $data = [];
        for ($i = 1; $i < 13; $i++) {
            $data[$i] = Purchase::whereYear('created_at', Date('Y'))
                ->whereMonth('created_at', (string) $i)
                ->count('id');
        }
        return implode(', ', $data);
    }

    /**
    Display costing report
     *
    @return \Illuminate\View\View
     */
    public function purchaseReport()
    {
        $this->authorize('report', Purchase::class);
        return view('report.cost.cost');
    }

    /**
     * Generate cost report & Print
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\View\View
     */
    public function generateReport(Request $request)
    {
        $this->authorize('report', Purchase::class);
        $reportCard = [];
        if ($request->input('year-month')) {
            $reportCard = [
                'time' => $request->input('year-month'),
                'total_cost' => $this->_monthlyBuilder('total_cost', $request),
                'total_qty' => $this->_monthlyBuilder('total_qty', $request),
                'tax_amount' => $this->_monthlyBuilder('tax_amount', $request),
                'total_payment' => $this->_monthlyBuilder('total_payment', $request),
                'shipping' => $this->_monthlyBuilder('shipping', $request),
                'off_amount' => $this->_monthlyBuilder('discount_amount', $request),
                'list' => $this->_monthlyBuilder('id', $request, true),
            ];
        }
        if ($request->date_s && $request->date_e) {
            $reportCard = [
                'time' => $request->date_s . ' to ' . $request->date_e,
                'total_cost' => $this->_periodBuilder('total_cost', $request),
                'total_qty' => $this->_periodBuilder('total_qty', $request),
                'tax_amount' => $this->_periodBuilder('tax_amount', $request),
                'total_payment' => $this->_periodBuilder('total_payment', $request),
                'shipping' => $this->_periodBuilder('shipping', $request),
                'off_amount' => $this->_periodBuilder('discount_amount', $request),
                'list' => $this->_periodBuilder('id', $request, true),
                'date_s' => $request->date_s,
                'date_e' => $request->date_e,
            ];
        }
        if ($request->frame) {
            $reportCard = [
                'time' => ucwords($request->frame),
                'total_cost' => $this->_frameBuilder('total_cost', $request),
                'total_qty' => $this->_frameBuilder('total_qty', $request),
                'tax_amount' => $this->_frameBuilder('tax_amount', $request),
                'total_payment' => $this->_frameBuilder('total_payment', $request),
                'shipping' => $this->_frameBuilder('shipping', $request),
                'off_amount' => $this->_frameBuilder('discount_amount', $request),
                'list' => $this->_frameBuilder('id', $request, true),
                'frame' => $request->frame,
            ];
        }
        if (request()->input('print') === 'yes') {
            return view('report.cost.costPrint', compact('reportCard'));
        }
        event(
            new LogActivity(
                $reportCard['time'],
                trans('feed.costReportGenerated'),
                trans('feed.report')
            )
        );
        return view('report.cost.cost')
            ->with('reportData', json_encode($reportCard))
            ->with('reportCard', $reportCard);
    }

    /**
     *  Monthly report buildrt
     *
     * @param mixed $value   The value
     * @param mixed $request The request
     * @param bool  $total   The total
     *
     * @return mixed
     */
    private function _monthlyBuilder($value, $request, $total = null)
    {
        $key = explode('-', $request->input('year-month'));
        if ($total) {
            return $this->_countOrders($key[0], $key[1]);
        }
        return $this->_sumUp($value, $key[1], $key[0]);
    }

    /**
     * Generate purchase report by period
     *
     * @param mixed $value   The value
     * @param mixed $request The request
     * @param mixed $total   The total
     *
     * @return mixed
     */
    private function _periodBuilder($value, $request, $total = null)
    {
        $period = [$request->date_s . " 00:00:00", $request->date_e . " 23:59:59"];
        $result = Purchase::whereBetween('created_at', $period);
        if ($total) {
            return $result->get();
        }
        return $result->sum($value);
    }

    /**
     * Generate by frame
     *
     * @param mixed $value   The value
     * @param mixed $request The request
     * @param mixed $total   The total
     *
     * @return mixed
     */
    private function _frameBuilder($value, $request, $total = null)
    {
        $frame = Carbon::today();
        if ('yesterday' == $request->frame) {
            $frame = date("Y-m-d", strtotime('-1 days'));
        }
        $collection = Purchase::whereDate('created_at', $frame);
        if ($total) {
            return $collection->get();
        }
        return $collection->sum($value);
    }

    /**
     * Counts the number of orders.
     *
     * @param String $year  The year
     * @param String $month The month
     *
     * @return mixed
     */
    private function _countOrders($year, $month)
    {
        return Purchase::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();
    }

    /**
     * Sum up value
     *
     * @param String $key   The key
     * @param String $month The month
     * @param String $year  The year
     *
     * @return mixed
     */
    private function _sumUp($key, $month, $year)
    {
        return Purchase::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum($key);
    }
}
