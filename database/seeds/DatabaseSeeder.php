<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
    Seed the application's database.

    @return void
     */
    public function run()
    {
        // Generating Default actounts
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MasterSeeder::class);
        $this->call(AdminAccountSeeder::class);
        $this->call(ManagerAccountSeeder::class);
        $this->call(PurchaserAccountSeeder::class);
        $this->call(SellerAccountSeeder::class);

        //Default settings
        $this->call(SettingSeeder::class);
        //Default Tax
        $this->call(TaxSeeder::class);
        //Default Walking Customer
        $this->call(CustomerSeeder::class);
        //Default Payment Gateways
        $this->call(PaymentGatewaySeeder::class);

    }
}
