<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryMan extends Model
{
  use SoftDeletes;
  protected $fillable=[
  	'phone_no', 'address', 'user_id', 'city_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function city()
  {
    return $this->belongsTo('App\City');
  }

  public function townships(){
             return $this->belongsToMany('App\Township','delivery_man_township','delivery_men_id','township_id')
      ->withTimestamps();;
    }

  public function pickups()
  {
    return $this->hasMany('App\Pickup');
  }

  public function ways()
  {
    return $this->hasMany('App\Way');
  }
}
