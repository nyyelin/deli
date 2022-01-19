<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Expense extends Model
{
  use SoftDeletes;
	protected $fillable=[
  	'amount', 'guest_amount', 'description', 'expense_type_id' , 'status', 'client_id', 'staff_id', 'city_id', 'item_id',
  ];

  public function expense_type()
  {
    return $this->belongsTo('App\ExpenseType');
  }

  public function client()
  {
    return $this->belongsTo('App\Client');
  }

  public function staff()
  {
    return $this->belongsTo('App\Staff');
  }

  public function city()
  {
    return $this->belongsTo('App\City');
  }

  public function item()
  {
    return $this->belongsTo('App\Item');
  }

  public function transaction()
  {
    return $this->hasOne('App\Transaction');
  }

  public function transactions()
  {
    return $this->hasMany('App\Transaction');
  }
}
