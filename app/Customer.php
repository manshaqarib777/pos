<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'vat', 'address'];
    
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function refund()
    {
        return $this->hasMany(Refund::class);
    }
}
