<?php
/**
 * File name: Currency.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Currency extends Model
{

    public $table = 'currencies';



    public $fillable = [
        'name',
        'symbol',
        'code',
        'decimal_digits',
        'rounding'
    ];




}
