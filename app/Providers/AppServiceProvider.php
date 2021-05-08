<?php
namespace App\Providers;

use App\Setting;
use Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App;

class AppServiceProvider extends ServiceProvider
{

    /**
     Bootstrap any application services.

     @return void
     */
    public function boot()
    {
        // Increase StringLength
        Schema::defaultStringLength(191);

        if (Schema::hasTable('settings') && Setting::find('1')) {
            $setting = Setting::find('1');
            $encryption = $setting->mail_encryption;
            if (strtoupper($setting->mail_encryption) === strtoupper('null')) {
                $encryption = '';
            }
            $config = array(
             'driver'     => $setting->mail_driver,
             'host'       => $setting->mail_host,
             'port'       => $setting->mail_port,
             'username'   => $setting->mail_user,
             'password'   => $setting->mail_password,
             'encryption' => $encryption,
             'from' => ['address' => $setting->default_email, 'name' => $setting->site_name],
             );
            Config::set('mail', $config);
            App::setlocale($setting->locale);
        }
    }
}
