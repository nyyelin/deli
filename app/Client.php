<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
  use SoftDeletes;
  protected $fillable=[
  	'contact_person', 'phone_no', 'address', 'codeno', 'user_id', 'township_id','account','owner'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function township()
  {
    return $this->belongsTo('App\Township');
  }

  public function schedules()
  {
    return $this->hasMany('App\Schedule');
  }
}
