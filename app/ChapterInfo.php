<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterInfo
{
    private $chapter;

    public function __construct($chapter)
    {
        $this->chapter = $chapter;
    }

    public function info()
    {
        $saleAmount = $this->chapter->payables;
        $refundAmount = $this->chapter->refundables;
        $saleBalance = ($saleAmount-$refundAmount);
        $netBalance = ($this->chapter->surcharges) + $saleBalance;
        $cashInHands =$this->chapter->total_cash_in_hands;
        $closingAmount = $netBalance + $cashInHands;
        return [
            'saleAmount'=> $saleAmount,
            'refundAmount'=> $refundAmount,
            'saleBalance'=> $saleBalance,
            'refundedCharges'=> $this->chapter->surcharges,
            'netBalance'=> $netBalance,
            'closingAmount'=> $closingAmount,
            'cashInHands' =>$cashInHands,
            'holdOnOrders' => count(explode(",", $this->chapter->holdOnOrders))-1,
        ];
    }
}
