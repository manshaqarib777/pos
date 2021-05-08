<?php
use Illuminate\Database\Seeder;
use App\Customer;

class CustomerSeeder extends Seeder
{
    /**
     Run the database seeds.

     @return void
     */
    public function run()
    {
        Customer::create(
            [
            'name'=>'Walk in customer',
            'email'=>'no-reply@domain.com',
            'phone'=>'+1 786 788 8787',
            'address'=>'This is address.',
            'vat'=>'EMV0000017889',
            ]
        );
    }
}
