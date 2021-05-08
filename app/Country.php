<?php
/**
 * File name: Country.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    public $table = 'countries';



    public $fillable = [
        'name',
        'code',
        'active',
        'currency_id',
    ];


    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class, 'currency_id', 'id');
    }
}
