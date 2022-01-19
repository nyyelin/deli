<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reback extends Model
{
  use SoftDeletes;
  protected $fillable=[
    'remark', 'pickup_id', 'way_id'
  ];

  public function pickup()
  {
    return $this->belongsTo('App\Pickup');
  }

  public function way()
  {
    return $this->belongsTo('App\Way');
  }
}
