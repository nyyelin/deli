<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
  use SoftDeletes;

  protected $fillable = ['bank_id', 'income_id', 'expense_id', 'tobank_id', 'amount', 'description', 'item_id'];

  public function bank()
  {
    return $this->belongsTo('App\Bank');
  }

  public function tobank()
  {
    return $this->belongsTo('App\Bank','tobank_id');
  }

  public function income()
  {
    return $this->belongsTo('App\Income');
  }

  public function item()
  {
    return $this->belongsTo('App\Item');
  }

  public function expense()
  {
    return $this->belongsTo('App\Expense');
  }
}
