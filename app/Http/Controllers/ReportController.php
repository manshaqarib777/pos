<?php
/**
 * This file implements Report Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  ReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Report;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a report object and updates
 * the view whenever data changes.
 *
 * @category Class
 * @package  ReportController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Report::class);
        $user_id = auth()->user()->id;
        if ($user_id < 2) {
            $reports = Report::latest()->paginate(11);
        } else {
            $reports = Report::latest()
                ->Where('user_id', $user_id)->paginate(11);
        }

        return view('report.saved.index', compact('reports'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('save', Report::class);
        $report = Report::create(
            [
                'reportData' => $request->reportData,
                'user_id' => $request->user_id,
                'type' => $request->type,
            ]
        );
        event(
            new LogActivity(
                trans('feed.reportType') . ' | ' . $request->type . ' | #' . $report->id,
                trans('feed.reportSaved'),
                trans('feed.report')
            )
        );
        return redirect(route('home'))
            ->with('success', trans('feed.reportSavedSuccessfully'));
    }

    /**
     *  Display the specified resource
     *
     * @param \App\Report $report The report
     *
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        $this->authorize('view', Report::class);
        if ('sale' == $report->type) {
            return view('report.sale.salePrint')
                ->with('reportCard', json_decode($report->reportData, true));
        }
        if ('cost' == $report->type) {
            return view('report.cost.costPrint')
                ->with('reportCard', json_decode($report->reportData, true));
        }
        if ('tax' == $report->type) {
            return view('report.tax.taxPrint')
                ->with('reportCard', json_decode($report->reportData, true));
        }
    }

    /**
     * Destroys the given report.
     *
     * @param \App\Report $report The report
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Report $report)
    {
        $this->authorize('manage', Report::class);
        $report->delete();
        event(
            new LogActivity(
                trans('feed.reportType') . ' | ' . $report->type . ' | #' . $report->id,
                trans('feed.reportDeletedSuccessfully'),
                trans('feed.report')
            )
        );
        return redirect(route('report.index'))
            ->With('success', trans('feed.reportDeletedSuccessfully'));
    }
}
