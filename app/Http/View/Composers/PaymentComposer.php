<?php
namespace App\Http\View\Composers;

use App\Payment;
use Illuminate\View\View;

class PaymentComposer
{
    public function compose(View $view)
    {
        $view->with('gateways', Payment::latest()->get());
    }
}
