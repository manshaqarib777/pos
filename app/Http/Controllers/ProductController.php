<?php
/**
 * This file implements Product Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  ProductController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Events\LogActivity;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Product object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  ProductController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class ProductController extends Controller
{
    /**
    Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('prepareBefore')->only('create');
    }

    /**
    Product debatable give access to management.

    @param \App\DataTables\ProductDataTable $dataTable The data table

    @return \Illuminate\View\View
     */
    public function index(ProductDataTable $dataTable)
    {
        $this->authorize('manage', Product::class);
        return $dataTable->render('management.products.list');
    }

    /**
    Show the form for creating a new resource

    @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        return view('entries.product.create');
    }

    /**
    Store a newly created resource in storage.

    @param \App\Http\Requests\ProductRequest $request The request

    @return \Illuminate\Http\JsonResponse.
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('create', Product::class);
        $product = Product::create($this->_vaildProduct($request, true));
        event(
            new LogActivity(
                $product->name,
                ' ' . trans('feed.newProductAdded'),
                'Product'
            )
        );
        return response()->json(
            ['message' => trans('feed.productCreated')],
            200
        );
    }

    /**
    Display the specified resource

    @param \App\Product $product The product

    @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        $this->authorize('manage', Product::class);
        return view('management/products/show', compact('product'));
    }

    /**
    Show the form for editing the specified resource

    @param \App\Product $product The product

    @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $this->authorize('manage', Product::class);
        return view('management.products.edit', compact('product'));
    }

    /**
    Update the specified resource in storage.

    @param \App\Http\Requests\ProductRequest $request The request
    @param \App\Product                      $product The product

    @return \Illuminate\Http\JsonResponse.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('manage', Product::class);
        $product->update($this->_vaildProduct($request));
        event(
            new LogActivity(
                $product->name,
                ' ' . trans('feed.productUpdated'),
                trans('feed.product')
            )
        );
        return response()->json(
            ['message' => trans('feed.productUpdated')],
            200
        );
    }

    /**
    Destroys the given product.

    @param \App\Product $product The product

    @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Product $product)
    {
        $this->authorize('manage', Product::class);
        $this->checkLogoExistence($product->image);
        event(
            new LogActivity(
                $product->name,
                ' ' . trans('feed.productRemoved'),
                trans('feed.product')
            )
        );
        $product->delete();
        return redirect(route('product.index'))
            ->with('success', trans('feed.deletedSuccessfully'));
    }

    /**
    Product display for POS

    @param Request $request The request

    @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function products(Request $request)
    {
        if ($request->category_id) {
            return Product::where('qty', '>', 0)
                ->where('category_id', $request->category_id)->get();
        }
        if ($this->bluePrints()->default_category) {
            return Product::where('qty', '>', 0)
                ->where('category_id', $this->bluePrints()->default_category)
                ->paginate($this->bluePrints()->product_limit);
        }
        return Product::where('status', 1)->where('qty', '>', 0)
            ->paginate($this->bluePrints()->product_limit);
    }

    /**
     * Provide product values
     *
     * @param mixed $request The request
     * @param mixed $store   The store
     *
     * @return array
     */
    private function _vaildProduct($request, $store = null)
    {
        $data = [
            'name' => $request->name,
            'code' => $this->generateCode($request),
            'type' => $request->type,
            'unit' => $request->unit,
            'cost' => $request->cost,
            'price' => $request->price,
            'product_details' => $request->product_details,
            'warehouse_id' => $request->warehouse,
            'supplier_id' => $request->supplier,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'expiry_date' => $request->expiry_date,
            'manufacturing_date' => $request->manufacturing_date,
            'side_effects' => $request->side_effects,

        ];
        if ($store) {
            $data['barcode_symbology'] = $this->bluePrints()->barcode_symbology;
            $data['discountable'] = $this->bluePrints()->discountable;
            $data['status'] = $this->bluePrints()->status;
            $data['tax_id'] = $this->bluePrints()->tax;
            $data['alert_quantity'] = $this->bluePrints()->alert_quantity;
        } else {
            $data['barcode_symbology'] = $request->barcode_symbology;
            $data['discountable'] = $request->discountable;
            $data['status'] = $request->status;
            $data['tax_id'] = $request->tax;
            $data['alert_quantity'] = $request->alert_quantity;
        }
        return $data;
    }

    /**
     * Product Image
     *
     * @param Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function image(Request $request)
    {
        $request->validate(
            [
                'image' => 'required|image|file',
            ]
        );
        $product = Product::find($request->product_id);
        $this->checkLogoExistence($product->image);
        $image = $request->image->store('uploads/products', 'public');
        $product->update(['image' => $image]);
        event(
            new LogActivity(
                $product->name,
                'product logo updated',
                'product'
            )
        );
        return back()->with('success', trans('feed.updatedSuccessfully'));
    }
}
