<?php
/**
 * This file implements POS(Point of Sale) Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  PosController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Session;

/**
 * Controls the data flow into a POS object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  PosController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class PosController extends Controller
{
    /**
    Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('posChapter');
    }

    /**
    Display a listing of the resource

    @return \Illuminate\View\View
     */
    public function index()
    {
        return view('portal/pos/index');
    }

    /**
    Adds the specified request.

    @param Request $request The request

    @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $product = Product::where('status', '1')->find($request->id);
        if ($product['id'] > 0) {
            $this->_secureAdd($product);
            return response()->json(
                [
                    'type' => 'success',
                    'message' => trans('feed.itemAdded'),
                ],
                200
            );
        }
        return response()->json(
            [
                'type' => 'warning',
                'message' => trans('feed.itemDisabled'),
            ],
            200
        );
    }

    /**
    Edit Cart item

    @param Request $request The request

    @return \Illuminate\Http\JsonResponse
     */
    public function itemEdit(request $request)
    {
        if (auth()->user()->pin !== $request->item['userPin']) {
            return response()->json(
                ['type' => 'warning', 'message' => trans('feed.invalidAuthPIN')],
                200
            );
        }

        if ($request->item) {
            $cart = new Cart(Session::get('cart') ?? '');
            $cart->update($request->item);
            $this->_prepareSession($cart);
            return response()->json(
                [
                    'type' => 'success',
                    'message' => trans('feed.itemUpdated'),
                ],
                200
            );
        }
    }

    /**
     * Shows the cart items
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCart(Request $request)
    {
        //Retrive from holded if requested
        if ($request->holdOnOrderKey) {
            $this->_setSession(Session::get($request->holdOnOrderKey));
            Session::forget($request->holdOnOrderKey);
            $chapter = $this->activeChapter();
            $holdOnOrders = explode(",", $chapter->holdOnOrders);
            unset(
                $holdOnOrders[
                    array_search($request->holdOnOrderKey, $holdOnOrders)
                ]
            );
            $chapter->update(['holdOnOrders' => implode(",", $holdOnOrders)]);
        }
        $cart = new Cart(Session::get('cart') ?? '');
        return response()->json(
            [
                'products' => $cart->getProducts(),
                'totalQty' => $cart->getTotalQty(),
                'totalPrice' => $cart->getTotal()],
            200
        );
    }

    /**
    Destroy Cart ,clear items

    @return \Illuminate\Http\JsonResponse
     */
    public function destroyCart()
    {
        Session::forget('cart');
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.cartIsEmpty'),
            ],
            200
        );
    }

    /**
    Removes the specified item identifier.

    @param Number $itemId The item identifier

    @return \Illuminate\Http\JsonResponse
     */
    public function remove($itemId)
    {
        $cart = new Cart(Session::get('cart') ?? '');
        $cart->remove($itemId);
        $this->_prepareSession($cart);
        return response()->json(
            [
                'message' => trans('feed.itemRemoved'),
                'type' => 'success',
            ],
            200
        );
    }

    /**
    Cart item quantity change

    @param Request $request The request

    @return \Illuminate\Http\JsonResponse
     */
    public function qtyChange(Request $request)
    {
        $request->validate(['numeric']);
        $stack = Product::find($request->id)->qty;
        if ($stack > $request->qty) {
            $cart = new Cart(Session::get('cart') ?? '');
            $cart->qtyChange($request->id, $request->qty);
            $this->_prepareSession($cart);
            return response()->json(
                [
                    'message' => trans('feed.quantityUpdated'),
                    'type' => 'success',
                ],
                200
            );
        }
        return response()->json(
            [
                'message' => $stack . ' ' . trans('feed.availableOnlyInStack'),
                'type' => 'warning',
            ],
            200
        );
    }

    /**
    Add item to cart by scanning bar-code

    @param Request $request The request

    @return \Illuminate\Http\JsonResponse
     */
    public function scan(request $request)
    {
        $this->validate(
            $request,
            [
                'code' => 'required|regex:/^[0-9 ]+$/|numeric',
            ]
        );
        $product = Product::where('code', $request->code)->first();
        if ($product->id > 0) {
            $this->_secureAdd($product);
            return response()->json(
                [
                    'type' => 'success',
                    'message' => trans('feed.itemAdded'),
                ],
                200
            );
        }
        return response()->json(
            [
                'type' => 'error',
                'message' => trans('feed.notFound'),
            ],
            200
        );
    }

    /**
    Searches for the first match.

    @param \Illuminate\Http\Request $request The request

    @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'search' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            ]
        );
        $items = Product::where('name', 'LIKE', $validated['search'] . '%')
            ->orWhere('code', 'LIKE', $validated['search'] . '%')
            ->get();
        return response()->json(
            [
                'type' => 'success',
                'items' => $items,
            ],
            200
        );
    }

    /**
    Add to cart

    @param Mixed $product The product

    @return Cart
     */
    private function _secureAdd($product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : '';
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $this->_setSession($cart);
    }

    /**
     * Prepairs Session
     *
     * @param mixed $name The name
     *
     * @return null
     */
    private function _prepareSession($name)
    {
        $this->_setSession($name);
        //Make sure if cart has zero item session should forget
        if ($name->getTotal() == 0) {
            Session::forget('cart');
        }
    }

    /**
     * Sets the session.
     *
     * @param mixed  $session The session
     * @param string $key     The key
     *
     * @return null
     */
    private function _setSession($session, $key = null)
    {
        Session::put($key ?? 'cart', $session);
        Session::save();
    }

    /**
     * Hold Orders
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function holdOn(Request $request)
    {
        $this->validate(
            $request,
            [
                'key' => 'required|regex:/^[A-Za-z ]+$/',
            ]
        );
        $this->_setSession(Session::get('cart'), $request->key);
        Session::forget('cart');
        $chapter = $this->activeChapter();
        $holdedOrdersKeys = explode(",", $chapter->holdOnOrders);
        array_push($holdedOrdersKeys, $request->key);
        $chapter->update(['holdOnOrders' => implode(",", $holdedOrdersKeys)]);
        return response()->json(
            ['type' => 'success', 'message' => trans('feed.orderHoldedSuccessfully')],
            200
        );
    }
}
