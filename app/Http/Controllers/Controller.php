<?php
/**
 * This file implements Controller.
 * PHP version 7.2
 *
 * @category Class
 * @package  Controller
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controls the data flow into a controller object and
 *  updates the view whenever data changes.
 *
 * @category Class
 * @package  Controller
 * @author   Rose-Finch <info.codehas@gmail.com>
 * @license  https://codecanyon.net/licenses/standard  Standard Licenses
 * @link     https://www.codehas.com
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Convert in killo
     *
     * @param integer $value The value
     *
     * @return integer
     */
    protected function intoKillo($value)
    {
        return $value / 1000;
    }

    /**
     * Check file existense
     *
     * @param string $imageUrl The image url
     *
     * @return Null
     */
    protected function checkLogoExistence($imageUrl)
    {
        if ('default_img/no_image.png' !== $imageUrl && file_exists('storage/' . $imageUrl)
        ) {
            unlink('storage/' . $imageUrl);
        }
    }

    /**
     * Generate code sting
     *
     * @param mixed $request The request
     *
     * @return string
     */
    protected function generateCode($request)
    {
        if ($request->code) {
            return $request->code;
        }
        return random_int(11, 99) . time();
    }

    /**
     * Gives Blue prints configs
     *
     * @return mixed
     */
    protected function bluePrints()
    {
        return Setting::find(1);
    }

    /**
     * Gives Opened chapter
     *
     * @return mixed
     */
    protected function activeChapter()
    {
        return auth()->user()->chapters->where('status', 1)->first();
    }

    /**
     * Gives Permsssion keys for groups
     *
     * @param mixed $request The request
     *
     * @return array
     */
    protected function permissionKeys($request)
    {
        return [
            'product_add' => $request->product_add,
            'product_manage' => $request->product_manage,
            'product_inventory' => $request->product_inventory,
            'category_add' => $request->category_add,
            'category_manage' => $request->category_manage,
            'subcategory_add' => $request->subcategory_add,
            'subcategory_manage' => $request->subcategory_manage,
            'supplier_add' => $request->supplier_add,
            'supplier_manage' => $request->supplier_manage,
            'customer_add' => $request->customer_add,
            'customer_manage' => $request->customer_manage,
            'purchase_add' => $request->purchase_add,
            'purchase_manage' => $request->purchase_manage,
            'purchase_summary' => $request->purchase_summary,
            'purchase_report' => $request->purchase_report,
            'expense_add' => $request->expense_add,
            'expense_manage' => $request->expense_manage,
            'expense_summary' => $request->expense_summary,
            'warehouse_add' => $request->warehouse_add,
            'warehouse_manage' => $request->warehouse_manage,
            'tax_add' => $request->tax_add,
            'tax_manage' => $request->tax_manage,
            'tax_summary' => $request->tax_summary,
            'tax_report' => $request->tax_report,
            'setting_view' => $request->setting_view,
            'setting_general' => $request->setting_general,
            'setting_logo' => $request->setting_logo,
            'setting_mail' => $request->setting_mail,
            'setting_product_default' => $request->setting_product_default,
            'setting_impects' => $request->setting_impects,
            'setting_pos' => $request->setting_pos,
            'setting_backup' => $request->setting_backup,
            'setting_dashboard' => $request->setting_dashboard,
            'setting_quick_mail' => $request->setting_quick_mail,
            'user_manage' => $request->user_manage,
            'user_edit' => $request->user_edit,
            'user_create' => $request->user_create,
            'group_add' => $request->group_add,
            'group_manage' => $request->group_manage,
            'group_request' => $request->group_request,
            'group_request_manage' => $request->group_request_manage,
            'sale_create' => $request->sale_create,
            'sale_manage' => $request->sale_manage,
            'sale_summary' => $request->sale_summary,
            'sale_report' => $request->sale_report,
            'refund_create' => $request->refund_create,
            'refund_manage' => $request->refund_manage,
            'refund_summary' => $request->refund_summary,
            'payment_add' => $request->payment_add,
            'payment_manage' => $request->payment_manage,
            'logs_view' => $request->logs_view,
            'logs_manage' => $request->logs_manage,
            'chapter_open' => $request->chapter_open,
            'chapter_close' => $request->chapter_close,
            'chapter_manage' => $request->chapter_manage,
            'reports_save' => $request->reports_save,
            'reports_view' => $request->reports_view,
            'reports_manage' => $request->reports_manage,
        ];
    }

    /**
     * Load Locals
     *
     * @param string $locale The locale
     *
     * @return mixed
     */
    public function lang($locale)
    {
        $locale = in_array($locale, config('app.exitingLangs')) ? $locale : config('app.fallback_locale');
        $files = glob(resource_path('lang/' . $locale . '/*.php'));
        $strings = [];
        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = include $file;
        }
        $contents = 'window.codehas = ' . json_encode($strings, config('app.debug', false) ? JSON_PRETTY_PRINT : 0) . ';';
        $response = \Response::make($contents, 200);
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
}
