<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable =['reportData','user_id','type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
