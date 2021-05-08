<?php

/**
 * This file implements Supplier Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  SupplierController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\DataTables\SupplierDataTable;
use App\Events\LogActivity;
use App\Http\Requests\SupplierRequest;
use App\Supplier;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Supplier object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  SupplierController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SupplierController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Supplier debatable give access to management.
     *
     * @param \App\DataTables\SupplierDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(SupplierDataTable $dataTable)
    {
        $this->authorize('manage', Supplier::class);
        return $dataTable->render('management.suppliers.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);
        return view('entries.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SupplierRequest $request The request
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(SupplierRequest $request)
    {
        $this->authorize('create', Supplier::class);
        $supplier = Supplier::create($this->_validSupplier($request));
        event(
            new LogActivity(
                $supplier->name,
                ' ' . trans('feed.newSupplierCreated'),
                'supplier'
            )
        );
        return response()->json(['message' => trans('feed.supplierCreated')], 200);
    }

    /**
     * Display the specified resource
     *
     * @param \App\Supplier $supplier The supplier
     *
     * @return \Illuminate\View\View
     */
    public function show(Supplier $supplier)
    {
        $this->authorize('manage', Supplier::class);
        return view('management.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param \App\Supplier $supplier The supplier
     *
     * @return \Illuminate\View\View
     */
    public function edit(Supplier $supplier)
    {
        $this->authorize('manage', Supplier::class);
        return view('management.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SupplierRequest $request  The request
     * @param \App\Supplier                      $supplier The supplier
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $this->authorize('manage', Supplier::class);
        $supplier->update($this->_validSupplier($request));
        event(
            new LogActivity(
                $supplier->name,
                ' ' . trans('feed.supplierInformationUpdated'),
                trans('feed.supplier')
            )
        );
        return response()->json(
            ['message' => trans('feed.supplierUpdated')],
            200
        );
    }

    /**
     * Destroys the given supplier.
     *
     * @param \App\Supplier $supplier The supplier
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('manage', Supplier::class);
        if ($supplier->purchases->count() > 0) {
            return back()->with('warning', trans('feed.supplierHasPurchases'));
        }
        if ($supplier->products->count() > 0) {
            return back()->with('warning', trans('feed.supplierHasProducts'));
        }
        $supplier->delete();
        event(
            new LogActivity(
                $supplier->name,
                ' ' . trans('feed.supplierDeleted'),
                trans('feed.supplier')
            )
        );
        return redirect(route('supplier.index'))
            ->with('success', trans('feed.deletedSuccessfully'));
    }

    /**
     * Provides Valid Supplier
     *
     * @param Request $request The request
     *
     * @return array
     */
    private function _validSupplier($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
            'vat' => $request->vat,
            'address' => $request->address,
        ];
    }
}
