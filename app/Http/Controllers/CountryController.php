<?php
/**
 * This file implements Country Controller.
 * PHP version 7.2
 *
 * @country Class
 * @package  CountryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Country;
use App\DataTables\CountryDataTable;
use App\Events\LogActivity;
use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;

/**
 * Controls the data flow into a country object and
 *  updates the view whenever data changes.
 *
 * @country Class
 * @package  CountryController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class CountryController extends Controller
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

    @param \App\DataTables\CountryDataTable $dataTable The data table

    @return \Illuminate\View\View
     */
    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('management.countries.list');
    }

    /**
    Show the form for creating a new resource.

    @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Country::class);
        return view('entries.country.create');
    }

    /**
    Store a newly created resource in storage.

    @param \App\Http\Requests\CountryRequest $request The request

    @return \Illuminate\Http\JsonResponse.
     */
    public function store(CountryRequest $request)
    {
        $cat = Country::create($this->_vaildCountry($request));
        event(
            new LogActivity(
                $cat->name,
                trans('feed.newCountryAdded'),
                trans('feed.country')
            )
        );
        return response()->json(
            ['message' => trans('feed.countryCreated')]
        );
    }

    /**
    Display the specified resource

    @param \App\Country $country The country

    @return \Illuminate\View\View
     */
    public function show(Country $country)
    {
        $this->authorize('manage', Country::class);
        return view('management.countries.show', compact('country'));
    }

    /**
    Show the form for editing the specified resource

    @param \App\Country $country The country

    @return \Illuminate\View\View
     */
    public function edit(Country $country)
    {
        $this->authorize('create', Country::class);
        return view('management.countries.edit', compact('country'));
    }

    /**
    Update the specified resource in storage.

    @param \App\Http\Requests\CountryRequest $request  The request
    @param \App\Country                      $country The country

    @return \Illuminate\Http\JsonResponse
     */
    public function update(CountryRequest $request, Country $country)
    {
        $this->authorize('manage', Country::class);
        $country->update($this->_vaildCountry($request));
        event(
            new LogActivity(
                $country->name,
                trans('feed.countryUpdated'),
                trans('feed.country')
            )
        );
        return response()->json(
            ['message' => trans('feed.countryUpdated')],
            200
        );
    }

    /**
    Destroys the given country.
    Check $country has sub countries
    Check $country has products

    @param \App\Country $country The country

    @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Country $country)
    {
        $this->authorize('manage', Country::class);
        if ($country->subcountries->count() > 0) {
            return back()->with('warning', trans('feed.countryhasSubCategories'));
        }
        if ($country->products->count() > 0) {
            return back()->with('info', trans('feed.countryHasProducts'));
        }
        $this->checkLogoExistence($country->image);
        event(
            new LogActivity(
                $country->name,
                trans('feed.countryRemoved'),
                trans('feed.country')
            )
        );
        $country->delete();
        return redirect(route('country.index'))
            ->with('info', trans('feed.deletedSuccessfully'));
    }

    /**
    $country Image

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
        $country = Country::find($request->country_id);
        $this->checkLogoExistence($country->image);
        $image = $request->image->store('uploads/country', 'public');
        $country->update(['image' => $image]);
        event(
            new LogActivity(
                $country->name,
                trans('feed.countrylogoUpdated'),
                trans('feed.country')
            )
        );
        return back()->with('success', trans('feed.updatedSuccessfully'));
    }

    /**
     * Validate country
     *
     * @param mixed $request The request
     *
     * @return array
     */
    private function _vaildCountry($request)
    {
        return [
            'name' => $request->name,
        ];
    }
}
