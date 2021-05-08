<?php
/**
 * This file implements SaleReport Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  SaleReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a SaleReportController object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  SaleReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SaleReportController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate Year summary
     *
     * @return \Illuminate\View\View
     */
    public function saleSummary()
    {
        $this->authorize('summary', Sale::class);
        $sales = Sale::latest()->get();
        //By Sale paramoters
        $saleData = $this->_saleOverall($sales);

        // Calculate sale data for charts
        $orders = $this->_totalSaleOrders();
        $tax_amount = $this->_yearlySale('tax_amount');
        $sale = $this->_yearlySale('payable');
        $discount = $this->_yearlySale('discount_amount');
        $profit = $this->_yearlySale('order_profit');
        event(
            new LogActivity(
                trans('feed.sale'),
                trans('feed.annualSaleChart'),
                trans('feed.chart')
            )
        );
        //Loads view
        return view(
            'finance.sale.detail',
            compact(
                ['saleData', 'tax_amount', 'sale', 'discount', 'orders', 'profit']
            )
        );
    }

    /**
     * Sale Overall give whole details
     *
     * @param Mixed $sales The sale
     *
     * @return array
     */
    private function _saleOverall($sales)
    {
        //By default
        $saleData = ['orders' => 0, 'cost' => 0, 'sale' => 0,
            'tax' => 0, 'discount' => 0, 'profit' => 0, 'lowPricing' => 0];

        //Total sale orders
        $saleData['orders'] = $sales->count();

        //Total Sale details ,
        foreach ($sales as $order) {
            $saleData['sale'] += $order->payable;
            $saleData['tax'] += $order->tax_amount;
            $saleData['discount'] += $order->discount_amount;
            $saleData['profit'] += $order->order_profit;
            $saleData['lowPricing'] += $order->lowPricing;
        }

        return $saleData;
    }

    /**
     * Calculate sale data
     *
     * @param String $key The key
     *
     * @return String
     */
    private function _yearlySale($key)
    {
        $saleData = [];
        for ($month = 1; $month < 13; $month++) {
            $saleData[$month] = $this->intoKillo(
                Sale::whereYear('created_at', Date('Y'))
                    ->whereMonth('created_at', (string) $month)
                    ->sum($key)
            );
        }
        return implode(', ', $saleData);
    }

    /**
     * Calculate sale orders
     *
     * @return String
     */
    private function _totalSaleOrders()
    {
        $orders = [];
        for ($i = 1; $i < 13; $i++) {
            $orders[$i] = Sale::whereYear('created_at', Date('Y'))
                ->whereMonth('created_at', (string) $i)->count('id');
        }
        return implode(', ', $orders);
    }

    /**
     * Display Sale Report
     *
     * @return \Illuminate\View\View
     */
    public function saleReport()
    {
        $this->authorize('report', Sale::class);
        return view('report.sale.sale');
    }

    /**
     * Generate report
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\View\View
     */
    public function generateSaleReport(Request $request)
    {
        $this->authorize('report', Sale::class);
        $reportCard = [];
        if ($request->input('year-month')) {
            $reportCard = [
                'time' => $request->input('year-month'),
                'type' => $request->type,
                'tax_amount' => $this->_saleReport('tax_amount', $request),
                'discount' => $this->_saleReport('discount_amount', $request),
                'total_price' => $this->_saleReport('total_price', $request),
                'total_items' => $this->_saleReport('total_items', $request),
                'payable' => $this->_saleReport('payable', $request),
                'profit' => $this->_saleReport('order_profit', $request),
                'list' => $this->_saleReport('id', $request, true),
            ];
        }
        if ($request->date_s && $request->date_e) {
            $reportCard = [
                'time' => $request->date_s . ' to ' . $request->date_e,
                'type' => $request->type,
                'tax_amount' => $this->_periodFilter('tax_amount', $request),
                'discount' => $this->_periodFilter('discount_amount', $request),
                'total_price' => $this->_periodFilter('total_price', $request),
                'total_items' => $this->_periodFilter('total_items', $request),
                'payable' => $this->_periodFilter('payable', $request),
                'profit' => $this->_periodFilter('order_profit', $request),
                'list' => $this->_periodFilter('id', $request, true),
                'date_s' => $request->date_s,
                'date_e' => $request->date_e,
            ];
        }
        if ($request->frame) {
            $reportCard = [
                'time' => $request->frame,
                'type' => $request->type,
                'tax_amount' => $this->_frameFilter('tax_amount', $request),
                'discount' => $this->_frameFilter('discount_amount', $request),
                'total_price' => $this->_frameFilter('total_price', $request),
                'total_items' => $this->_frameFilter('total_items', $request),
                'payable' => $this->_frameFilter('payable', $request),
                'profit' => $this->_frameFilter('order_profit', $request),
                'list' => $this->_frameFilter('id', $request, true),
                'frame' => $request->frame,
            ];
        }

        if ('yes' === $request->print) {
            return view('report.sale.salePrint')
                ->with('reportData', json_encode($reportCard))
                ->with('reportCard', $reportCard);
        }
        event(
            new LogActivity(
                $reportCard['type'] ? trans('feed.regular') : trans('feed.walkin'),
                trans('feed.saleReportGenerated') . ' ' . $reportCard['time'],
                trans('feed.report')
            )
        );
        return view('report.sale.sale')
            ->with('reportData', json_encode($reportCard))
            ->with('reportCard', $reportCard);
    }

    /**
     * Generate Report
     *
     * @param String $value   The value
     * @param Mixed  $request The request
     * @param Bool   $all     All
     *
     * @return Int
     */
    private function _saleReport($value, $request, $all = null)
    {
        $key = explode('-', $request->input('year-month'));
        //Type for regular or walk in customer
        $type = null;
        if (0 == $request->type) {
            $type = true;
        }
        //Sale summary for report
        $data = $this->_getSaleSum($value, $key[0], $key[1], $type);
        if ($all) {
            //Total sale orders
            $data = $this->_getSaleOrders($key[0], $key[1], $type);
        }
        return $data;
    }

    /**
     * Sale Report by period
     *
     * @param mixed $value   The value
     * @param mixed $request The request
     * @param mixed $total   The total
     *
     * @return mixed
     */
    private function _periodFilter($value, $request, $total = null)
    {
        $type = null;
        if (0 == $request->type) {
            $type = true;
        }
        $period = [$request->date_s . " 00:00:00", $request->date_e . " 23:59:59"];
        $result = Sale::whereBetween('created_at', $period)
            ->where('customer_id', $type ?? '>', 1);
        if ($total) {
            return $result->get();
        }
        return $result->sum($value);
    }

    /**
     * Generate sale report by time frame
     *
     * @param mixed $value   The value
     * @param mixed $request The request
     * @param mixed $total   The total
     *
     * @return mixed
     */
    private function _frameFilter($value, $request, $total = null)
    {
        $type = null;
        if (0 == $request->type) {
            $type = true;
        }
        $frame = Carbon::today();
        if ('yesterday' == $request->frame) {
            $frame = date("Y-m-d", strtotime('-1 days'));
        }
        $collection = Sale::whereDate('created_at', $frame)
            ->where('customer_id', $type ?? '>', 1);
        if ($total) {
            return $collection->get();
        }
        return $collection->sum($value);
    }

    /**
     * Gets the sale summary.
     *
     * @param String $saleValue The sale value
     * @param String $year      The year
     * @param String $month     The month
     * @param Bool   $type      The type
     *
     * @return mixed
     */
    private function _getSaleSum($saleValue, $year, $month, $type)
    {
        return Sale::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('customer_id', $type ?? '>', 1)
            ->sum($saleValue);
    }

    /**
     * Gets the sale orders.
     *
     * @param String $theYear      The year
     * @param String $theMonth     The month
     * @param Bool   $customerType The customer type
     *
     * @return mixed
     */
    private function _getSaleOrders($theYear, $theMonth, $customerType)
    {
        return Sale::whereYear('created_at', $theYear)
            ->whereMonth('created_at', $theMonth)
            ->where('customer_id', $customerType ?? '>', 1)
            ->get();
    }
}
