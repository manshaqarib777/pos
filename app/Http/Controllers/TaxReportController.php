<?php
/**
 * This file implements Tax Report Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  TaxReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Purchase;
use App\Refund;
use App\Sale;
use App\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a TaxReport object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  TaxReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class TaxReportController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    Generate Yearly Summary

    @return \Illuminate\View\View
     */
    public function taxSummary()
    {
        $this->authorize('summary', Tax::class);
        //Allover tax summery
        $data['purchase'] = $this->_totalTax(
            Purchase::latest()
                ->get()
        );
        $data['walkin'] = $this->_totalTax(
            Sale::where('customer_id', 1)
                ->get()
        );
        $data['customer'] = $this->_totalTax(
            Sale::where('customer_id', '>', 1)
                ->get()
        );
        //for charts
        $purchaseTax = $this->_yearlyPurchaseTax();
        $walkinTax = $this->_yearlyWalkInSaleTax();
        $customerTax = $this->_yearlyRegularSaleTax();
        event(
            new LogActivity(
                trans('feed.tax'),
                trans('feed.annualTaxChart'),
                trans('feed.chart')
            )
        );
        return view(
            'finance.tax.detail',
            compact(
                [
                    'data',
                    'customerTax',
                    'walkinTax',
                    'purchaseTax',
                ]
            )
        );
    }

    /**
     * Calculates the tax.
     *
     * @param Mixed $from The from
     *
     * @return integer  The tax.
     */
    private function _totalTax($from)
    {
        $counted = 0;
        foreach ($from as $value) {
            $counted += $value->tax_amount;
        }
        return $counted;
    }

    /**
     *  Purchase tax summary
     *
     * @return String
     */
    private function _yearlyPurchaseTax()
    {
        $purchaseTax = [];
        for ($i = 1; $i < 13; $i++) {
            $purchaseTax[$i] = $this->intoKillo(
                $this->_purchaseTaxMonthly(Date('Y'), (string) $i)
            );
        }
        return implode(', ', $purchaseTax);
    }

    /**
     * Yearly Walking Customer tax collection
     *
     * @return String
     */
    private function _yearlyWalkInSaleTax()
    {
        $saleTax = [];
        for ($i = 1; $i < 13; $i++) {
            $saleTax[$i] = $this->intoKillo(
                $this->_saleTaxMonthly(Date('Y'), (string) $i, false)
            );
        }
        return implode(', ', $saleTax);
    }

    /**
     * Regular customer tax collection
     *
     * @return String
     */
    private function _yearlyRegularSaleTax()
    {
        $regularTax = [];
        for ($i = 1; $i < 13; $i++) {
            $regularTax[$i] = $this->intoKillo(
                $this->_saleTaxMonthly(Date('Y'), (string) $i, true)
            );
        }
        return implode(', ', $regularTax);
    }

    /**
    Generate Tax report

    @return \Illuminate\View\View
     */
    public function taxReport()
    {
        $this->authorize('report', Tax::class);
        return view('report.tax.tax');
    }

    /**
    Generate Tax report view and print.

    @param \Illuminate\Http\Request $request The request

    @return \Illuminate\View\View
     */
    public function generateReport(Request $request)
    {
        $this->authorize('report', Tax::class);
        $report = [];
        if ($request->input('year-month')) {
            $key = explode('-', $request->input('year-month'));
            $report = [
                'time' => $request->input('year-month'),
                //Walk in customer Sale and refund orders tax
                'walkin' => $this->_saleTaxMonthly($key[0], $key[1], false),
                'walkinRefund' => $this->_refundTaxMonthly($key[0], $key[1], false),
                //Regular Customer sale and refund Orders tax
                'customer' => $this->_saleTaxMonthly($key[0], $key[1], true),
                'customerRefund' => $this->_refundTaxMonthly($key[0], $key[1], true),
                //purchase Order tax
                'purchase' => $this->_purchaseTaxMonthly($key[0], $key[1]),
            ];
        }
        if ($request->date_s && $request->date_e) {
            $report = [
                'time' => $request->date_s . ' To ' . $request->date_e,
                //Walk in customer Sale and refund orders tax
                'walkin' => $this->_saleTaxFromPeriod($request, false),
                'walkinRefund' => $this->_refundTaxFromPeriod($request, false),
                //Regular Customer sale and refund Orders tax
                'customer' => $this->_saleTaxFromPeriod($request, true),
                'customerRefund' => $this->_refundTaxFromPeriod($request, true),
                //purchase Order tax
                'purchase' => $this->_purchaseTaxFromPeriod($request),
            ];
        }
        if ($request->frame) {
            $report = [
                'time' => $request->frame,
                //Walk in customer Sale and refund orders tax
                'walkin' => $this->_saleTaxByTimeFrame($request, false),
                'walkinRefund' => $this->_refundTaxByTimeFrame($request, false),
                //Regular Customer sale and refund Orders tax
                'customer' => $this->_saleTaxByTimeFrame($request, true),
                'customerRefund' => $this->_refundTaxByTimeFrame($request, true),
                //purchase Order tax
                'purchase' => $this->_purchaseTaxByTimeFrame($request),
            ];
        }
        //Total Walk in tax after tax fall (in case of refund)
        $report['walkinNet'] = $report['walkin'] - $report['walkinRefund'];
        //Total regular customer after tax fall
        $report['customerNet'] = $report['customer'] - $report['customerRefund'];
        //Total Sale Tax collection (regular and walking)
        $report['saleTax'] = $report['walkinNet'] + $report['customerNet'];
        //Total tax including Purchase Orders
        $report['totalTax'] = $report['saleTax'] + $report['purchase'];

        if ($request->input('print') === 'yes') {
            return view('report.tax.taxPrint')->with('reportCard', $report);
        }
        event(
            new LogActivity(
                $report['time'],
                trans('feed.taxReportGenerated'),
                trans('feed.report')
            )
        );
        return view('report.tax.tax')
            ->with('reportData', json_encode($report))->with('reportCard', $report);
    }

    /**
     * Calculates Sale tax
     *
     * @param string  $year  The year
     * @param string  $month The month
     * @param boolean $type  The type
     *
     * @return Integer
     */
    private function _saleTaxMonthly($year, $month, $type)
    {
        return Sale::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('customer_id', !$type ? 1 : '>', 1)
            ->sum('tax_amount');
    }

    /**
     * Sale tax by period
     *
     * @param mixed   $request The request
     * @param boolean $type    The type
     *
     * @return int
     */
    private function _saleTaxFromPeriod($request, $type)
    {
        $period = [$request->date_s . " 00:00:00", $request->date_e . " 23:59:59"];
        $saleTax = Sale::whereBetween('created_at', $period);
        return $saleTax->where('customer_id', !$type ? 1 : '>', 1)
            ->sum('tax_amount');
    }

    /**
     * Sale tax by time frame
     *
     * @param mixed   $request The request
     * @param boolean $type    The type
     *
     * @return int
     */
    private function _saleTaxByTimeFrame($request, $type)
    {
        $frame = Carbon::today();
        if ('yesterday' == $request->frame) {
            $frame = date("Y-m-d", strtotime('-1 days'));
        }
        $saleTax = Sale::whereDate('created_at', $frame)
            ->where('customer_id', !$type ? 1 : '>', 1);
        return $saleTax->sum('tax_amount');
    }

    /**
    Gets the refund report.

    @param string $year  The year
    @param string $month The month
    @param bool   $type  The type

    @return int
     */
    private function _refundTaxMonthly($year, $month, $type)
    {
        return Refund::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('customer_id', $type ?? '>', 1)
            ->sum('tax_amount');
    }

    /**
     * Refund tax fall by period
     *
     * @param mixed $request The request
     * @param bool  $type    The type
     *
     * @return int
     */
    private function _refundTaxFromPeriod($request, $type)
    {
        $period = [$request->date_s . " 00:00:00", $request->date_e . " 23:59:59"];
        $refundTax = Refund::whereBetween('created_at', $period);
        return $refundTax->where('customer_id', $type ?? '>', 1)->sum('tax_amount');
    }

    /**
     * Refund tax fall by time frame
     *
     * @param mixed $request The request
     * @param bool  $type    The type
     *
     * @return int
     */
    private function _refundTaxByTimeFrame($request, $type)
    {
        $frame = Carbon::today();
        if ('yesterday' == $request->frame) {
            $frame = date("Y-m-d", strtotime('-1 days'));
        }
        $refundTax = Refund::whereDate('created_at', $frame)
            ->where('customer_id', $type ?? '>', 1);
        return $refundTax->sum('tax_amount');
    }

    /**
    Gets the purchase report.

    @param string $year  The year
    @param string $month The month

    @return int
     */
    private function _purchaseTaxMonthly($year, $month)
    {
        return Purchase::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('tax_amount');
    }

    /**
     * Purchase tax report by period
     *
     * @param mixed $request The request
     *
     * @return int
     */
    private function _purchaseTaxFromPeriod($request)
    {
        $period = [$request->date_s . " 00:00:00", $request->date_e . " 23:59:59"];
        return Purchase::whereBetween('created_at', $period)->sum('tax_amount');
    }

    /**
     * Purchase tax report by time frame
     *
     * @param mixed $request The request
     *
     * @return int
     */
    private function _purchaseTaxByTimeFrame($request)
    {
        $frame = Carbon::today();
        if ('yesterday' == $request->frame) {
            $frame = date("Y-m-d", strtotime('-1 days'));
        }
        return Purchase::whereDate('created_at', $frame)->sum('tax_amount');
    }
}
