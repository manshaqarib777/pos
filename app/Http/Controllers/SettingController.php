<?php
/**
 * This file implements Setting Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  SettingController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Events\LogActivity;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Controls the data flow into a Setting object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  SettingController
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class SettingController extends Controller
{
    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('demoCheck')->only('mail', 'image');
    }

    /**
     * Display current setting ,gives access to change,
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', Setting::class);
        $setting = $this->bluePrints();
        return view('setting.setting', compact(['setting']));
    }

    /**
     * Email configuration
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Setting             $setting The setting
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function mail(Request $request, Setting $setting)
    {
        $this->authorize('mail', Setting::class);
        $validated = $this->validate(
            $request,
            [
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required|numeric',
                'mail_user' => 'required',
                'mail_password' => 'required',
                'mail_encryption' => 'required',
            ]
        );
        $setting->update($validated);
        event(
            new LogActivity(
                trans('feed.mail'),
                ' ' . trans('feed.mailConfigurationUpdated'),
                trans('feed.setting')
            )
        );
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.mailConfigurationUpdated'),
            ],
            200
        );
    }

    /**
     * General Setting
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Setting             $setting The setting
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function update(Request $request, Setting $setting)
    {
        $this->authorize('general', $setting);
        $validate = $this->validate(
            $request,
            [
                'default_email' => 'required|email',
                'address_1' => 'required',
                'site_name' => 'required',
                'skin' => 'required',
                'address_2' => 'required',
                'phone' => 'required',
                'refund_prefix' => 'required|regex:/^[A-Z]+$/|max:10',
                'registration_number' => 'required',
                'currency' => 'required',
                'sale_prefix' => 'required|regex:/^[A-Z]+$/|max:10',
                'purchase_prefix' => 'required|regex:/^[A-Z]+$/|max:10',
                'vat' => 'required',
                'default_group' => 'required',
                'locale' => 'required',
            ]
        );
        $setting->update($validate);
        event(
            new LogActivity(
                trans('feed.general'),
                ' ' . trans('feed.generalSettingUpdated'),
                'Setting'
            )
        );
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.settingUpdated'),
            ],
            200
        );
    }

    /**
     * Main logo
     *
     * @param Request $request The request
     *
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function image(Request $request)
    {
        $request->validate(
            [
                'image' => 'required|image|file',
            ]
        );
        $this->authorize('logo', $this->bluePrints());
        $this->checkLogoExistence($this->bluePrints()->image);
        $image = $request->image->store('uploads/setting', 'public');
        $this->bluePrints()->update(['image' => $image]);
        event(
            new LogActivity(
                trans('feed.logo'),
                ' ' . trans('feed.mainLogoUpdated'),
                trans('feed.setting')
            )
        );
        return back()->with('success', trans('feed.updatedSuccessfully'));
    }

    /**
     * Sets Profuct Defaults
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Setting             $setting The setting
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function product(Request $request, Setting $setting)
    {
        $this->authorize('productDefaults', Setting::class);
        $validated = $this->validate(
            $request,
            [
                'status' => 'required',
                'discountable' => 'required',
                'tax' => 'required|numeric',
                'barcode_symbology' => 'required',
                'alert_quantity' => 'required',
            ]
        );
        $setting->update($validated);
        event(
            new LogActivity(
                trans('feed.productDefaults'),
                ' ' . trans('feed.productDefaultUpdated'),
                trans('feed.setting')
            )
        );
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.productDefaultConfigurationUpdated'),
            ],
            200
        );
    }

    /**
     * Sets Inventory Impacts
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Setting             $setting The setting
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function impact(Request $request, Setting $setting)
    {
        $this->authorize('impects', Setting::class);
        $validated = $this->validate(
            $request,
            [
                'dead_level' => 'required',
                'high_level' => 'required',
                'medium_level' => 'required|numeric',
                'low_level' => 'required',
                'normal_level' => 'required',
            ]
        );
        $setting->update($validated);
        event(
            new LogActivity(
                trans('feed.inventoryImpacts'),
                ' ' . trans('feed.impactsLevelsUpdated'),
                'Setting'
            )
        );
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.inventoryImpactsLevelsUpdated'),
            ],
            200
        );
    }

    /**
     * Point of sale configuration
     *
     * @param \Illuminate\Http\Request $request The request
     * @param \App\Setting             $setting The setting
     *
     * @return \Illuminate\Http\JsonResponse.
     */
    public function pos(Request $request, Setting $setting)
    {
        $this->authorize('pos', Setting::class);
        $valid = $this->validate(
            $request,
            [
                'qty_show' => 'required',
                'name_show' => 'required',
                'price_show' => 'required',
                'default_customer' => 'required|numeric',
                'default_tax' => 'required',
                'default_payment' => 'required',
                'discount_state' => 'required',
                'product_icon_skin' => 'required',
                'default_category' => 'required',
                'product_limit' => 'required',
                'quick_amounts' => 'required|regex:/^([0-9\s]+,)*([0-9\s]+){1}$/i',
            ]
        );
        $setting->update($valid);
        event(
            new LogActivity(
                trans('feed.pOSConfig'),
                ' ' . trans('feed.posConfigurationUpdated'),
                trans('feed.setting')
            )
        );
        return response()->json(
            [
                'type' => 'success',
                'message' => trans('feed.posConfigurationUpdated'),
            ],
            200
        );
    }
}
