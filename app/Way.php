<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\RejectNotification;
use Illuminate\Notifications\Notifiable;
class Way extends Model
{
  use SoftDeletes;
  use Notifiable;

	protected $fillable=[
  	'status_code', 'delivery_date', 'refund_date', 'item_id', 'delivery_man_id', 'staff_id', 'status_id','remark'
  ];

  public function item()
  {
    return $this->belongsTo('App\Item');
  }

  public function item_with_trash()
  {
    return $this->belongsTo('App\Item','item_id')->withTrashed();
  }
  
  public function delivery_man()
  {
    return $this->belongsTo('App\DeliveryMan','delivery_man_id');
  }

  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function status()
  {
    return $this->belongsTo('App\Status');
  }

  public function reback()
  {
    return $this->hasOne('App\Reback');
  }

  public function income()
  {
    return $this->hasOne('App\Income');
  }

}
