<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
    'name',
    'code',
    'type',
    'unit',
    'barcode_symbology',
    'alert_quantity',
    'cost',
    'price',
    'tax_id',
    'product_details',
    'warehouse_id',
    'supplier_id',
    'category_id',
    'subcategory_id',
    'image',
    'qty',
    'expiry_date',
    'manufacturing_date',
    'side_effects',
    'discountable',
    'status',
    'sold_out'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
