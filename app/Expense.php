<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['reference','amount', 'type', 'note', 'attachment', 'by'];
}
