<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ExpenseType extends Model
{
	use SoftDeletes;
  protected $fillable=[
  	'name'
  ];

  public function expenses()
  {
    return $this->hasMany('App\Expense');
  }
}
