<?php
/**
 * This file implements Category Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  CategoryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Category;
use App\DataTables\CategoryDataTable;
use App\Events\LogActivity;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

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
class CategoryController extends Controller
{
    /**
    Constructs a new instance.
    Middleware Applied
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    Categories debatable give access to management.

    @param \App\DataTables\CategoryDataTable $dataTable The data table

    @return \Illuminate\View\View
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('management.categories.list');
    }

    /**
    Show the form for creating a new resource.

    @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        return view('entries.category.create');
    }

    /**
    Store a newly created resource in storage.

    @param \App\Http\Requests\CategoryRequest $request The request

    @return \Illuminate\Http\JsonResponse.
     */
    public function store(CategoryRequest $request)
    {
        $cat = Category::create($this->_vaildCategory($request));
        event(
            new LogActivity(
                $cat->name,
                trans('feed.newCategoryAdded'),
                trans('feed.category')
            )
        );
        return response()->json(
            ['message' => trans('feed.categoryCreated')]
        );
    }

    /**
    Display the specified resource

    @param \App\Category $category The category

    @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $this->authorize('manage', Category::class);
        return view('management.categories.show', compact('category'));
    }

    /**
    Show the form for editing the specified resource

    @param \App\Category $category The category

    @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $this->authorize('create', Category::class);
        return view('management.categories.edit', compact('category'));
    }

    /**
    Update the specified resource in storage.

    @param \App\Http\Requests\CategoryRequest $request  The request
    @param \App\Category                      $category The category

    @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('manage', Category::class);
        $category->update($this->_vaildCategory($request));
        event(
            new LogActivity(
                $category->name,
                trans('feed.categoryUpdated'),
                trans('feed.category')
            )
        );
        return response()->json(
            ['message' => trans('feed.categoryUpdated')],
            200
        );
    }

    /**
    Destroys the given category.
    Check $category has sub categories
    Check $category has products

    @param \App\Category $category The category

    @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Category $category)
    {
        $this->authorize('manage', Category::class);
        if ($category->subcategories->count() > 0) {
            return back()->with('warning', trans('feed.categoryhasSubCategories'));
        }
        if ($category->products->count() > 0) {
            return back()->with('info', trans('feed.categoryHasProducts'));
        }
        $this->checkLogoExistence($category->image);
        event(
            new LogActivity(
                $category->name,
                trans('feed.categoryRemoved'),
                trans('feed.category')
            )
        );
        $category->delete();
        return redirect(route('category.index'))
            ->with('info', trans('feed.deletedSuccessfully'));
    }

    /**
    $category Image

    @param Request $request The request

    @return \Illuminate\Http\RedirectResponse.
     */
    public function image(Request $request)
    {
        Request()->validate(
            [
                'image' => 'required|image|file',
            ]
        );
        $category = Category::find($request->category_id);
        $this->checkLogoExistence($category->image);
        $image = $request->image->store('uploads/category', 'public');
        $category->update(['image' => $image]);
        event(
            new LogActivity(
                $category->name,
                trans('feed.categorylogoUpdated'),
                trans('feed.category')
            )
        );
        return back()->with('success', trans('feed.updatedSuccessfully'));
    }

    /**
     * Validate category
     *
     * @param mixed $request The request
     *
     * @return array
     */
    private function _vaildCategory($request)
    {
        return [
            'name' => $request->name,
            'code' => $this->generateCode($request),
            'detail' => $request->detail,
        ];
    }
}
