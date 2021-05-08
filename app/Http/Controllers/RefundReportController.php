<?php
/**
 * This file implements Refund Report Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  RefundReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Refund;

/**
 * Controls the data flow into a refund object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  RefundReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard Standard Licenses
 * @link     https://www.codehas.com
 */
class RefundReportController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate Yearly summary
     *
     * @return \Illuminate\View\View
     */
    public function refundSummary()
    {
        $this->authorize('summary', Refund::class);
        $refundData = $this->_refundOrdersData();
        $orders = $this->_countRefundOrders();
        $items = $this->_refundOrderSummary('return_items');
        $tax_amount = $this->_refundOrderSummary('tax_amount');
        $charge_amount = $this->_refundOrderSummary('charge_amount');
        $refundable = $this->_refundOrderSummary('refundable');
        event(
            new LogActivity(
                trans('feed.refund'),
                trans('feed.annualRefundChart'),
                trans('feed.chart')
            )
        );
        return view(
            'finance.refund.detail',
            compact(
                [
                    'refundData', 'items', 'tax_amount',
                    'charge_amount', 'refundable', 'orders',
                ]
            )
        );
    }

    /**
     * Overall Refund orders summary
     *
     * @return array  ( description_of_the_return_value )
     */
    private function _refundOrdersData()
    {
        //Fetch Refund orders
        $refundOrders = Refund::latest()->get();
        //By default
        $refundData = [
            'orders' => 0,
            'items' => 0,
            'tax_amount' => 0,
            'charge_amount' => 0,
            'refundable' => 0,
        ];
        //Count Total Orders
        $refundData['orders'] = $refundOrders->count();
        //Sum up data
        foreach ($refundOrders as $order) {
            $refundData['items'] += $order->return_items;
            $refundData['tax_amount'] += $order->tax_amount;
            $refundData['charge_amount'] += $order->charge_amount;
            $refundData['refundable'] += $order->refundable;
        }
        return $refundData;
    }

    /**
     * Refund Orders monthly Summary
     *
     * @param String $key The key
     *
     * @return String
     */
    private function _refundOrderSummary($key)
    {
        $data = [];
        for ($month = 1; $month < 13; $month++) {
            $data[$month] = $this->intoKillo(
                Refund::whereYear('created_at', Date('Y'))
                    ->whereMonth('created_at', (string) $month)
                    ->sum($key)
            );
        }
        return implode(', ', $data);
    }

    /**
     * Counts the number of monthly refund orders.
     *
     * @return String
     */
    private function _countRefundOrders()
    {
        $orders = [];
        for ($i = 1; $i < 13; $i++) {
            $orders[$i] = Refund::whereYear('created_at', Date('Y'))
                ->whereMonth('created_at', (string) $i)
                ->count('id');
        }
        return implode(', ', $orders);
    }
}
