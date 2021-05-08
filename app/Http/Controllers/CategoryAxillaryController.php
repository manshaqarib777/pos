<?php
/**
 * This file implements Category Axillary Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  CategoryAxillaryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Category;

/**
 * Controls the data flow into a Category Axillary object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  CategoryAxillaryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class CategoryAxillaryController extends Controller
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Gives all categories for Point of sale.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        $categories = Category::latest()->get();
        return response()->json(
            $categories,
            200
        );
    }

    /**
     * $category has $subcategories for point of sale.
     *
     * @param \App\Category $category The category
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function child(Category $category)
    {
        return response()->json(
            [
                'type' => 'success',
                'subcategories' => $category->subcategories,
            ],
            200
        );
    }
}
