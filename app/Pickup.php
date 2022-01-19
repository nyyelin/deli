<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class Pickup extends Model
{
  use SoftDeletes;
  use Notifiable;
  protected $fillable=[
  	'status', 'schedule_id', 'delivery_man_id', 'staff_id'
  ];

  public function schedule()
  {
    return $this->belongsTo('App\Schedule');
  }

  public function delivery_man()
  {
    return $this->belongsTo('App\DeliveryMan');
  }
  
  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function rebacks()
  {
    return $this->hasMany('App\Reback');
  }

  public function items()
  {
    return $this->hasMany('App\Item');
  }

  public function expense()
  {
    return $this->hasOne('App\Expense');
  }

  public function expenses($value='')
  {
    return $this->hasMany('App\Expense');
   
  }
}
