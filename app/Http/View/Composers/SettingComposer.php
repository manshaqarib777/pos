<?php

namespace App\Http\View\Composers;

use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class SettingComposer
{
    public function compose(View $view)
    {
        $setting = [
            'site_name'           => 'Next POS',
            'address_1'           => '',
            'phone'               => '',
            'default_email'       => 'no-reply@yourdomain.com',
            'address_2'           => 'Sargodha, Pakistan.',
            'currency'            => '$',
            'sale_prefix'         => 'SALE',
            'vat'                 => 'EMOOOO0786',
            'purchase_prefix'     => 'PURCHASE',
            'skin'                => 'red',
            'refund_prefix'       => 'REFUND',
            'registration_number' => '786786786',
            'image'               => 'default_img/no_image.png',
            'mail_driver'         => '',
            'mail_password'       => '',
            'mail_host'           => '',
            'mail_port'           => '',
            'mail_user'           => '',
            'mail_encryption'     => '',
            ];

        if (Schema::hasTable('settings') && Setting::find('1')) {
            $setting = Setting::find('1');
        }
        $view->with('setting', $setting);
    }
}
