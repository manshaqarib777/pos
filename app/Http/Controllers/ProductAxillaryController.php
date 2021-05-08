<?php
/**
 * This file implements Product Axillary Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  ProductAxillaryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Product Axillary object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  ProductAxillaryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ProductAxillaryController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generate Product barcode & Print.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\View\View
     */
    public function label(Request $request)
    {
        $product = Product::find($request->product_id);
        $price = '';
        if ($request->price) {
            $price = 'Price: ' . $this->bluePrints()->currency . $product->price;
        }
        $config = [
            'times' => $request->amount ?? 11,
            'height' => $request->height,
            'fontSize' => $request->fontSize ?? 11,
            'width' => $request->width,
            'border' => $request->border ? 'label' : '',
            'padding' => $request->padding,
            'col' => $request->col,
            'price' => $price,
            'name' => $request->name ? ucwords($product->name) : '',
            'code' => $request->code ? $product->code : '',
            'company' => $request->company ? $this->bluePrints()->site_name : '',
            'symbology' => $request->symbology ?? '',
        ];
        return view('management.products.label', compact(['config']));
    }
}
