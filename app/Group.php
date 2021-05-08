<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','details','state','note','requestBy'];
    public function permissions()
    {
        return $this->hasOne(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
