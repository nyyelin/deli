<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Township extends Model
{
  use SoftDeletes;
  protected $fillable=[
  	'name', 'delivery_fees', 'delirate', 'status', 'city_id'
  ];

  public function city()
  {
    return $this->belongsTo('App\City');
  }

  public function delivery_men()
  {
    return $this->belongsToMany('App\DeliveryMan','delivery_man_township','township_id','delivery_men_id');
  }

  public function clients()
  {
    return $this->hasMany('App\Client');
  }

  public function items()
  {
    return $this->hasMany('App\Item');
  }
}
