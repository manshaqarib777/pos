<?php
use App\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
    Run the database seeds.

    @return void
     */
    public function run()
    {
        Setting::create(
            [
                'site_name' => 'Advance Next Point Of Sale',
                'default_email' => 'active-mail@yourdomain.com',
                'address_1' => '141 Coal Road',
                'address_2' => 'Tamaqua, PA 18252',
                'phone' => '+7866718114',
                'currency' => '$',
                'sale_prefix' => 'SALE',
                'refund_prefix' => 'REFUND',
                'purchase_prefix' => 'PURCHASE',
                'skin' => 'light-blue',
                'vat' => 'EMOOOO0786',
                'registration_number' => '786786786',
                'image' => 'default_img/no_image.png',

                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.mailtrap.io',
                'mail_port' => '2525',
                'mail_user' => 'd0d2fced847aa7',
                'mail_password' => 'a16813fa188946',
                'mail_encryption' => 'null',

                'status' => 1,
                'discountable' => 0,
                'barcode_symbology' => 'C39',
                'alert_quantity' => 5,
                'tax' => 1,
            ]
        );
    }
}
