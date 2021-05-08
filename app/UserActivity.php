<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $table = 'user_activities';

    protected $fillable = [
      'user_id',
      'type',
      'description',
      'reference',
      'archived'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
