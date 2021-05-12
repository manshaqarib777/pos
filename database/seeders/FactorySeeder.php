<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory('App\Customer',10)->create();
        factory('App\Expense', 10)->create();
        //factory('App\Tax',10)->create();
        factory('App\Product', 150)->create();
        factory('App\Supplier', 10)->create();
        factory('App\Warehouse', 10)->create();
        factory('App\Category', 10)->create();
        factory('App\Subcategory', 10)->create();
    }
}
