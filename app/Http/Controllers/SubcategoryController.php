<?php
/**
 * This file implements Subcategory Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  SubcategoryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */

namespace App\Http\Controllers;

use App\Category;
use App\DataTables\SubcategoryDataTable;
use App\Events\LogActivity;
use App\Http\Requests\SubcategoryRequest;
use App\Subcategory;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a Subcategory object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  SubcategoryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SubcategoryController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Subcategories debatable give access to management.
     *
     * @param \App\DataTables\SubcategoryDataTable $dataTable The data table
     *
     * @return \Illuminate\View\View
     */
    public function index(SubcategoryDataTable $dataTable)
    {
        return $dataTable->render('management.subcategories.list');
    }

    /**
     * Show the form for creating a new resource
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Subcategory::class);
        return view('entries.subcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SubcategoryRequest $request The request
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(SubcategoryRequest $request)
    {
        $subcategory = Subcategory::create($this->_validSubcategory($request));
        event(
            new LogActivity(
                $subcategory->name,
                ' ' . trans('feed.newSubcategoryAdded'),
                trans('feed.subcategory')
            )
        );
        return response()->json(
            ['message' => trans('feed.subcategoryCreated')],
            200
        );
    }

    /**
     * Display the specified resource
     *
     * @param \App\Subcategory $subcategory The subcategory
     *
     * @return \Illuminate\View\View
     */
    public function show(Subcategory $subcategory)
    {
        $this->authorize('manage', Subcategory::class);
        return view('management.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param \App\Subcategory $subcategory The subcategory
     *
     * @return \Illuminate\View\View
     */
    public function edit(Subcategory $subcategory)
    {
        $this->authorize('manage', Subcategory::class);
        return view('management.subcategories.edit', compact('subcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SubcategoryRequest $request     The request
     * @param \App\Subcategory                      $subcategory The subcategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubcategoryRequest $request, Subcategory $subcategory)
    {
        $this->authorize('manage', Subcategory::class);
        $subcategory->update($this->_validSubcategory($request));
        event(
            new LogActivity(
                $subcategory->name,
                ' ' . trans('feed.subcategoryUpdated'),
                'subcategory'
            )
        );
        return response()->json(
            ['message' => trans('feed.subcategoryUpdated')],
            200
        );
    }

    /**
     * Destroys the given subcategory.
     *
     * Check $subcategory has product.
     *
     * @param \App\Subcategory $subcategory The subcategory
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Subcategory $subcategory)
    {
        $this->authorize('manage', Subcategory::class);
        if ($subcategory->products->count() > 0) {
            return back()->with('warning', trans('feed.subcategoryHasProducts'));
        }
        $this->checkLogoExistence($subcategory);
        event(
            new LogActivity(
                $subcategory->name,
                ' ' . trans('feed.deletedSuccessfully'),
                trans('feed.subcategory')
            )
        );
        $subcategory->delete();
        return redirect(route('subcategory.index'))
            ->with('success', trans('feed.deletedSuccessfully'));
    }

    /**
     * Subcategory Image
     *
     * @param Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function image(Request $request)
    {
        $this->authorize('manage', Subcategory::class);
        $request->validate(
            [
                'image' => 'required|image|file',
            ]
        );
        $subcategory = Subcategory::find($request->subcategory_id);
        $this->checkLogoExistence($subcategory->image);
        $image = $request->image->store('uploads/subcategory', 'public');
        $subcategory->update(['image' => $image]);
        event(
            new LogActivity(
                $subcategory->name,
                ' ' . trans('feed.subcategorylogoUpdated'),
                trans('feed.subcategory')
            )
        );
        return back()->with('success', trans('feed.updatedSuccessfully'));
    }

    /**
     * Provides valid subcategory
     *
     * @param Request $request The request
     *
     * @return array
     */
    private function _validSubcategory($request)
    {
        return [
            'category_id' => $request->category,
            'name' => $request->name,
            'code' => $this->generateCode($request),
            'detail' => $request->detail,
        ];
    }
}
