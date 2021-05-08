<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['date', 'reference', 'customer_id', 'order_tax', 'tax_amount', 'discount_rate', 'discount_amount', 'staff_note', 'payable', 'enter_amount', 'change', 'total_items', 'total_price', 'products_data', 'biller_detail', 'order_profit', 'lowPricing','chapter_id','payment_gateway','payment_note'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
