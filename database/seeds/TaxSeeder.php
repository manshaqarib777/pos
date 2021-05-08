<?php
use Illuminate\Database\Seeder;
use App\Tax;

class TaxSeeder extends Seeder
{
    /**
     Run the database seeds.

     @return void
     */
    public function run()
    {
        Tax::create(
            [
            'name'=>'No Tax',
            'code'=>'NT_0%',
            'rate'=>'0',
            'type'=>'1',
            ]
        );
        Tax::create(
            [
            'name'=>'Value Added Tax',
            'code'=>'VAT_18%',
            'rate'=>'18',
            'type'=>'1',
            ]
        );
    }
}
