<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PaymentType extends Model
{
	use SoftDeletes;
  protected $fillable=[
  	'name'
  ];

  public function incomes()
  {
    return $this->hasMany('App\Income');
  }
}
