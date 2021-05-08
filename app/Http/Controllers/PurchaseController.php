<?php
/**
 * This file implements Purchase Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  PurchaseController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */

namespace App\Http\Controllers;

use App\DataTables\PurchaseDataTable;
use App\Events\LogActivity;
use App\Http\Requests\PurchaseRequest;
use App\Inventory;
use App\Purchase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

/**
 * Controls the data flow into a Purchase object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  PurchaseController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PurchaseController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Purchase debatable give access to management
     *
     * @param \App\DataTables\PurchaseDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(PurchaseDataTable $dataTable)
    {
        $this->authorize('manage', Purchase::class);
        return $dataTable->render('management.purchases.list');
    }

    /**
     * Show the form for creating a new resource
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Purchase::class);
        return view('entries.purchase.create');
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PurchaseRequest $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PurchaseRequest $request)
    {
        $this->authorize('create', Purchase::class);
        DB::beginTransaction();
        try {
            $inventory = new Inventory(Session::get('purchase'));
            $purchasedProducts = $inventory->getProducts();
            $totalQty = $inventory->getTotalQty();
            $totalCost = $inventory->getTotal();
            $purchase = Purchase::create(
                [
                    'date' => $request->date,
                    'reference' => strtoupper(
                        $this->bluePrints()->purchase_prefix
                    ) . '/' . $request->reference,
                    'discount_rate' => $request->discount_rate,
                    'discount_amount' => $request->discount_amount,
                    'staff_note' => $request->staff_note,
                    'shipping' => $request->shipping,
                    'by' => auth()->user()->name,
                    'status' => 0,
                    'supplier_id' => $request->supplier,
                    'tax_id' => $request->tax,
                    'tax_rate' => $request->tax_rate,
                    'tax_amount' => $request->tax_amount,
                    'total_payment' => $request->payable,
                    'total_cost' => $totalCost,
                    'total_qty' => $totalQty,
                    'Products' => json_encode($purchasedProducts),
                ]
            );
            DB::commit();
            Session::has('purchase') ? Session::forget('purchase') : '';
            event(
                new LogActivity(
                    $purchase->reference,
                    ' ' . trans('feed.newPurchaseOrderCreated'),
                    trans('feed.purchase')
                )
            );
            $response = [
                'type' => 'success',
                'reference' => $purchase->id,
                'message' => trans('feed.purchaseCreatedSuccessfully'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'type' => 'warning',
                'message' => trans('feed.failedExceptionError'),
            ];
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource
     *
     * @param \App\Purchase $purchase The purchase
     *
     * @return \Illuminate\View\View
     */
    public function show(Purchase $purchase)
    {
        return view('management.purchases.show', compact('purchase'));
    }

    /**
     * Destroys the given purchase.
     *
     * Check Order payment status.
     *
     * @param \App\Purchase $purchase The purchase
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Purchase $purchase)
    {
        $this->authorize('manage', Purchase::class);
        if ($purchase->status) {
            return back()->with('warning', trans('feed.purchaseOrderPaid'));
        }
        event(
            new LogActivity(
                $purchase->reference,
                ' ' . trans('feed.purchaseOrderRemoved'),
                trans('feed.purchase')
            )
        );
        $purchase->delete();
        return redirect(route('purchase.index'))
            ->with('success', trans('feed.deletedSuccessfully'));
    }
}
