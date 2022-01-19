<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Staff extends Model
{
  use SoftDeletes;
	protected $fillable=[
    'phone_no', 'address', 'joined_date', 'designation', 'user_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function pickups()
  {
    return $this->hasMany('App\Pickup');
  }

  public function ways()
  {
    return $this->hasMany('App\Way');
  }

  public function items()
  {
    return $this->hasMany('App\Item');
  }
}
