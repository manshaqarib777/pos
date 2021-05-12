<?php
namespace Database\Seeders;

use App\Payment;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
                'title'  => 'Cash Payment',
                'code'   => 'cash001',
                'state'  => 1,
                'detail' => 'Cash Payment (Update Description Byself)'
        ]);
        Payment::create([
                'title'  => 'Via Card',
                'code'   => 'via-card',
                'state'  => 1,
                'detail' => 'Card Payment (Update Description Byself)'
        ]);
    }
}
