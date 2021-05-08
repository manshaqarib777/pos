<?php

/**
 * This file implements Tax Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  TaxController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\DataTables\TaxDataTable;
use App\Events\LogActivity;
use App\Http\Requests\TaxRequest;
use App\Tax;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Tax object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  TaxController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class TaxController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tax debatable give access to management.
     *
     * @param \App\DataTables\TaxDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(TaxDataTable $dataTable)
    {
        $this->authorize('manage', Tax::class);
        return $dataTable->render('management.taxes.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Tax::class);
        return view('entries.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TaxRequest $request The request
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(TaxRequest $request)
    {
        $this->authorize('create', Tax::class);
        $tax = Tax::create($this->_validTaxValues($request));
        event(
            new LogActivity(
                $tax->name,
                ' ' . trans('feed.newTaxMethodCreated'),
                trans('feed.tax')
            )
        );
        return response()->json(
            ['message' => trans('feed.taxMethodCreated')],
            200
        );
    }

    /**
     * Display the specified resource
     *
     * @param \App\Tax $tax The tax
     *
     * @return \Illuminate\View\View
     */
    public function show(Tax $tax)
    {
        $this->authorize('manage', Tax::class);
        return view('management.taxes.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param \App\Tax $tax The tax
     *
     * @return \Illuminate\View\View
     */
    public function edit(Tax $tax)
    {
        $this->authorize('manage', Tax::class);
        return view('management.taxes.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\TaxRequest $request The request
     * @param \App\Tax                      $tax     The tax
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaxRequest $request, Tax $tax)
    {
        $this->authorize('manage', Tax::class);
        $tax->update($this->_validTaxValues($request));
        event(
            new LogActivity(
                $tax->name,
                ' ' . trans('feed.taxMethodUpdated'),
                trans('feed.tax')
            )
        );
        return response()->json(
            ['message' => trans('feed.taxMethodUpdated')],
            200
        );
    }

    /**
     * Destroys the given tax.
     *
     * Check Tax method in use or not
     *
     * Check Tax method in use with product
     *
     * @param \App\Tax $tax The tax
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Tax $tax)
    {
        $this->authorize('manage', Tax::class);
        if ($tax->purchases->count() > 0) {
            return back()->with('warning', trans('feed.taxMethodIsBeingUsed'));
        }
        if ($tax->products->count() > 0) {
            return back()->with('warning', trans('feed.taxMethodIsBeingUsed'));
        }
        $tax->delete();
        event(
            new LogActivity(
                $tax->name,
                ' ' . trans('feed.taxMethodDeleted'),
                trans('feed.tax')
            )
        );
        return redirect(route('tax.index'))
            ->with('success', trans('feed.deletedSuccessfully'));
    }

    /**
     * Display all tax methods for point of sale
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function taxes()
    {
        return Tax::latest()->get();
    }

    /**
     * Provides valid values
     *
     * @param Request $request The request
     *
     * @return array
     */
    private function _validTaxValues($request)
    {
        return [
            'name' => $request->name,
            'code' => $request->code,
            'rate' => $request->rate,
            'type' => 0,
        ];
    }
}
