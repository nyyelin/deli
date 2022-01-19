<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Bank extends Model
{
	use SoftDeletes;
  
  protected $fillable=[
  	'name', 'amount',
  ];

  public function transactions()
  {
    return $this->hasMany('App\Income');
  }
}
