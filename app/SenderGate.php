<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SenderGate extends Model
{
	use SoftDeletes;
    protected $fillable=[
  	'name'
  ];
}
