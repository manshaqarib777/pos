<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['date', 'reference', 'customer_id', 'sale_id', 'tax_rate', 'tax_amount', 'charge_rate', 'charge_amount', 'staff_note', 'refundable', 'return_items', 'refund_price', 'products_data', 'biller_detail','chapter_id'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
