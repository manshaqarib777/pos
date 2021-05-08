<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['user_id','key','status','walkin','regular', 'total_cash_in_hands','sale_orders','tax_amount','discount','sold_item','refund_orders','tax_fall','surcharges','refundables','closed_at','profit','low_price_index','payables','gatewayFilters','holdOnOrders'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
