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

use App\DataTables\SaleDataTable;
use App\Events\LogActivity;
use App\Payment;
use App\Product;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

/**
 * Controls the data flow into a category object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  CategoryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SaleController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Sale order debatable give access to management
     *
     * @param \App\DataTables\SaleDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(SaleDataTable $dataTable)
    {
        $this->authorize('manage', Sale::class);
        return $dataTable->render('finance/sale/list');
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
        $this->authorize('create', Sale::class);
        $this->validate(
            $request,
            [
                'tax' => 'required',
                'discount' => 'required|numeric|max:99|min:0|regex:/^[0-9 ]+$/',
                'staffNote' => 'required|regex:/^[A-Za-z0-9 ]+$/',
                'amount' => 'required|regex:/^[0-9 ]+$/',
                'gateway' => 'required',
                'paymentNote' => 'regex:/^[A-Za-z0-9 ]+$/',
            ]
        );
        DB::beginTransaction();
        try {
            $slip = $request;
            $cart = Session::get('cart');
            $items = $cart->getProducts();
            $profit = 0;
            $lowPricing = 0;
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                $profit += $item['price'] - $product->cost;
                $lowPricing += $product->price - $item['price'];
                $product->update(
                    [
                        'qty' => ($product->qty - $item['qty']),
                        'sold_out' => ($product->sold_out + $item['qty']),
                    ]
                );
            }
            $chapter = $this->activeChapter();
            $reference = strtoupper(
                $this->bluePrints()->sale_prefix
            ) . '/POS/' . time();
            $payment = Payment::find($slip['gateway']);
            $sale = Sale::create(
                [
                    'date' => time(),
                    'reference' => $reference,
                    'customer_id' => $slip['customer'],
                    'order_tax' => $slip['tax'],
                    'tax_amount' => $slip['computedTax'],
                    'discount_rate' => $slip['discount'],
                    'discount_amount' => $slip['computedDiscount'],
                    'staff_note' => $slip['staffNote'],
                    'payable' => $slip['computedPayable'],
                    'enter_amount' => $slip['amount'],
                    'change' => $slip['change'],
                    'order_profit' => $profit,
                    'lowPricing' => $lowPricing,
                    'total_items' => $cart->getTotalQty(),
                    'total_price' => $cart->getTotal(),
                    'products_data' => json_encode($cart->getProducts()),
                    'biller_detail' => auth()->user()->name,
                    'chapter_id' => $chapter->id,
                    'payment_note' => $slip['paymentNote'],
                    'payment_gateway' => $payment->title,
                ]
            );
            $gatewayAmounts = [];
            $existingAmount = 0;
            if ($chapter->gatewayFilters) {
                $gatewayAmounts = json_decode($chapter->gatewayFilters, true);
            }
            if (array_key_exists($payment->title, $gatewayAmounts)) {
                $existingAmount = $gatewayAmounts[$payment->title];
                unset($gatewayAmounts[$payment->title]);
            }
            $gatewayAmounts[$payment->title] = $existingAmount + $sale->payable;

            $chapter->update(
                [
                    'sale_orders' => $chapter->sale_orders + 1,
                    'tax_amount' => $chapter->currnet_sales + $slip['computedTax'],
                    'discount' => $chapter->discount + $slip['computedDiscount'],
                    'sold_item' => $chapter->sold_item + $cart->getTotalQty(),
                    'walkin' => $chapter->walkin + $slip['customer'] < 2 ? 1 : 0,
                    'regular' => $chapter->regular + $slip['customer'] > 1 ? 1 : 0,
                    'profit' => $chapter->profit + $profit,
                    'low_price_index' => $chapter->low_price_index + $lowPricing,
                    'payables' => $chapter->payables + $slip['computedPayable'],
                    'gatewayFilters' => json_encode($gatewayAmounts),
                ]
            );

            DB::commit();
            if (!$request->keepCart) {
                Session::has('cart') ? Session::forget('cart') : '';
            }
            event(
                new LogActivity(
                    $sale->reference,
                    ' ' . trans('feed.saleCreatedSuccessfully'),
                    trans('feed.sale')
                )
            );
            $response = [
                'reference' => $sale->id,
                'key' => $sale->reference,
                'message' => trans('feed.saleCreatedSuccessfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['type' => 'warning', 'message' => 'Exception error!'];
        }
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource
     *
     * @param \App\Sale $sale The sale
     *
     * @return \Illuminate\View\View
     */
    public function show(Sale $sale)
    {
        $this->authorize('manage', Sale::class);
        return view('finance/sale/show', compact('sale'));
    }

    /**
     * Print the specified resource
     *
     * @param \App\Sale $sale The sale
     *
     * @return \Illuminate\View\View
     */
    function print(Sale $sale)
    {
        return view('finance/sale/print', compact('sale'));
    }

    /**
     * Print A4 the specified resource
     *
     * @param \App\Sale $sale The sale
     *
     * @return \Illuminate\View\View
     */
    public function printA4(Sale $sale)
    {
        return view('finance/sale/showA4', compact('sale'));
    }

    /**
     * Destroys the given sale.
     *
     * @param \App\Sale $sale The sale
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Sale $sale)
    {
        $this->authorize('manage', Sale::class);
        $sale->delete();
        event(
            new LogActivity(
                $sale->reference,
                ' ' . trans('feed.orderRemovedSuccessfully'),
                trans('feed.sale')
            )
        );
        return redirect(route('sale.index'))
            ->with('success', trans('feed.saleOrderDeleted'));
    }
}
