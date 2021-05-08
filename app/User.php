<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     The attributes that are mass assignable.

     @var array
     */
    protected $fillable = [
    'name', 'email', 'password', 'phone', 'address', 'company', 'image', 'isActive','group_id','pin','log'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];
    /**
     The attributes that should be cast to native types.

     @var array
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function userActivites()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
