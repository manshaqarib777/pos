<?php
/**
 * This file implements refund Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  RefundController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\DataTables\RefundDataTable;
use App\Events\LogActivity;
use App\Product;
use App\Refund;
use App\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

/**
 * Controls the data flow into a refund object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  RefundController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class RefundController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Refund debatable give access to management.
     *
     * @param \App\DataTables\RefundDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(RefundDataTable $dataTable)
    {
        $this->authorize('manage', Refund::class);
        return $dataTable->render('finance/refund/list');
    }

    /**
     * Store a newly created resource in storage
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Refund::class);
        $this->validate(
            $request,
            [
                'tax_rate' => 'required',
                'charge_rate' => 'required|numeric|max:99|min:0|regex:/^[0-9 ]+$/',
                'staffNote' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            ]
        );
        DB::beginTransaction();
        try {
            $cart = Session::get('cart');
            $items = $cart->getProducts();
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                $product->qty = $product->qty + $item['qty'];
                $product->save();
            }
            $reference = strtoupper(
                $this->bluePrints()->refund_prefix
            ) . '/POS/' . time();
            $chapter = $this->activeChapter();
            $refund = Refund::create(
                [
                    'date' => time(),
                    'reference' => $reference,
                    'customer_id' => $request['customer'],
                    'sale_id' => $request['sale_id'],
                    'tax_rate' => $request['tax_rate'],
                    'tax_amount' => $request['tax_amount'],
                    'charge_rate' => $request['charge_rate'],
                    'charge_amount' => $request['charge_amount'],
                    'staff_note' => $request['staffNote'],
                    'refundable' => $request['refundable'],
                    'return_items' => $cart->getTotalQty(),
                    'refund_price' => $cart->getTotal(),
                    'products_data' => json_encode($cart->getProducts()),
                    'biller_detail' => auth()->user()->name,
                    'chapter_id' => $chapter->id,
                ]
            );
            $chapter->update(
                [
                    'refund_orders' => $chapter->refund_orders + 1,
                    'tax_fall' => $chapter->tax_fall + $refund->tax_amount,
                    'surcharges' => $chapter->surcharges + $refund->charge_amount,
                    'refundables' => $chapter->refundables + $refund->refundable,
                ]
            );
            event(
                new LogActivity(
                    $refund->reference,
                    ' ' . trans('feed.orderRefundedSuccessfully'),
                    trans('feed.refund')
                )
            );
            DB::commit();
            Session::has('cart') ? Session::forget('cart') : '';
            $response = [
                'reference' => $refund->id,
                'message' => trans('feed.refundSuccessfully')];
        } catch (Exception $e) {
            DB::rollBack();
            $response = [
                'type' => 'warning',
                'message' => 'Exception error!',
            ];
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource
     *
     * @param \App\Refund $refund The refund
     *
     * @return \Illuminate\View\View
     */
    public function show(Refund $refund)
    {
        return view('finance.refund.show', compact('refund'));
    }

    /**
     * Destroys the given refund.
     *
     * @param \App\Refund $refund The refund
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Refund $refund)
    {
        $this->authorize('manage', Refund::class);
        $refund->delete();
        event(
            new LogActivity(
                $refund->reference,
                ' ' . trans('feed.refundOrderRemoved'),
                trans('feed.refund')
            )
        );
        return redirect(route('refund.index'))
            ->with('success', trans('feed.refundOrderDeleted'));
    }

    /**
     * Print the specified resource
     *
     * @param \App\Refund $refund The refund
     *
     * @return \Illuminate\View\View
     */
    function print(Refund $refund)
    {
        return view('finance.refund.print', compact('refund'));
    }

    /**
     * Print A4 size the specified resource
     *
     * @param \App\Refund $refund The refund
     *
     * @return \Illuminate\View\View
     */
    public function printA4(Refund $refund)
    {
        return view('finance.refund.showA4', compact('refund'));
    }

    /**
     * Precheck sale order
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function confirmSale(Request $request)
    {
        $this->authorize('manage', Refund::class);
        $validated = $this->validate($request, ['reference' => 'required']);
        $reference = strtoupper(
            $this->bluePrints()->sale_prefix
        ) . '/POS/' . $validated['reference'];
        $sale = Sale::where('reference', $reference)->first();
        if ($sale) {
            event(
                new LogActivity(
                    $sale->reference,
                    ' ' . trans('feed.saleOrderConfirmedForRefund'),
                    trans('feed.refund')
                )
            );
            return response()->json(
                [
                    'sale_id' => $sale->id,
                    'type' => 'success',
                    'message' => trans('feed.saleOrderConfirmed'),
                ],
                200
            );
        }
        event(
            new LogActivity(
                'sale order',
                ' ' . trans('feed.orderNotConfirmedForRefund'),
                trans('feed.refund')
            )
        );
        return response()->json(
            [
                'sale_id' => '0',
                'type' => 'warning',
                'message' => trans('feed.notConfirmed'),
            ],
            200
        );
    }
}
