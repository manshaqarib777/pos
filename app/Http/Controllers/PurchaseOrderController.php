<?php
/**
 * This file implements Purchase Order Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  PurchaseOrderController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Inventory;
use App\Product;
use App\Purchase;
use Illuminate\Http\Request;
use Session;

/**
 * Controls the data flow into a Purchase Order object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  PurchaseOrderController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PurchaseOrderController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    Display product list cart to order

    @param Request $request The request

    @return \Illuminate\Http\JsonResponse.
     */
    public function products(Request $request)
    {
        //Forget Old customer session & prepair new as per customer
        Session::has('purchase') ? Session::forget('purchase') : '';
        $products = Product::where('supplier_id', $request->id)->get();
        foreach ($products as $product) {
            $inventory = new Inventory(Session::get('purchase') ?? '');
            $inventory->add($product, $product->id);
            //create & save session after adding new item,
            $this->_setSession($inventory);
        }
        return response()->json(
            [
                'type' => 'success',
                'purchase' => $this->_getDataFromSession(),
            ],
            200
        );
    }

    /**
    Change item quantity

    @param \Illuminate\Http\Request $request The request

    @return \Illuminate\Http\JsonResponse.
     */
    public function qtyChange(Request $request)
    {
        $inventory = new Inventory(Session::get('purchase') ?? '');

        //update quantity only when up to 0
        if ($request->qty > 0) {
            $inventory->qtyChange($request->id, $request->qty);

            //Set new session & check item existence (forget session if item null)
            $this->_checkItemInSession($inventory);

            return response()->json(
                [
                    'message' => trans('feed.quantityUpdated'),
                    'type' => 'success',
                    'purchase' => $this->_getDataFromSession(),
                ],
                200
            );
        }

        //Remove item from session if quantity is zero
        $inventory->remove($request->id);

        //Set new session & check item existence (forget session if item null)
        $this->_checkItemInSession($inventory);

        return response()->json(
            [
                'message' => trans('feed.itemRemoved'),
                'type' => 'success',
                'purchase' => $this->_getDataFromSession(),
            ],
            200
        );
    }

    /**
    Print the specified resource

    @param \App\Purchase $purchase The purchase

    @return \Illuminate\View\View
     */
    function print(Purchase $purchase)
    {
        return view('management.purchases.print', compact('purchase'));
    }

    /**
    Paid status

    @param \App\Purchase $purchase The purchase

    @return \Illuminate\Http\RedirectResponse.
     */
    public function paid(Purchase $purchase)
    {
        $this->authorize('manage', Purchase::class);
        $purchase->update(['status' => 1]);
        event(
            new LogActivity(
                $purchase->reference,
                ' ' . trans('feed.orderGotPaid'),
                trans('feed.purchase')
            )
        );
        return back()->with('success', trans('feed.purchaseGotPaid'));
    }

    /**
    Update stock quantity as per ordered

    @param \App\Purchase $purchase The purchase

    @return \Illuminate\Http\RedirectResponse.
     */
    public function stockUp(Purchase $purchase)
    {
        $this->authorize('manage', Purchase::class);
        $items = json_decode($purchase->Products);
        foreach ($items as $item) {
            $product = Product::find($item->id);
            $product->update(['qty' => ($product->qty + $item->qty)]);
        }
        $purchase->update(
            [
                'stock' => '1',
            ]
        );
        event(
            new LogActivity(
                $purchase->reference,
                ' ' . trans('feed.purchasedStockUpdated'),
                trans('feed.purchase')
            )
        );
        return back()
            ->with('success', trans('feed.stockQuantityUpdated'));
    }

    /**
     * Sets the session.
     *
     * @param mixed $sessionData The session data
     *
     * @return Null
     */
    private function _setSession($sessionData)
    {
        Session::put('purchase', $sessionData);
        Session::save();
    }

    /**
     * Make sure if session has item or null
     *
     * @param mixed $session The session
     *
     * @return null
     */
    private function _checkItemInSession($session)
    {
        $this->_setSession($session);

        if ($session->getTotalQty() < 1) {
            Session::forget('purchase');
        }
    }

    /**
     * Gets the data from session.
     *
     * @return array  The data from session.
     */
    private function _getDataFromSession()
    {
        $session = new Inventory(Session::get('purchase'));
        return [
            'products' => $session->getProducts(),
            'totalQty' => $session->getTotalQty(),
            'totalPrice' => $session->getTotal(),
        ];
    }
}
