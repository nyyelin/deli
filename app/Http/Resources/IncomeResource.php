<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\WayResource;
use App\Way;
class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
            'id'=>$this->id,
            'delivery_man' =>$this->way->delivery_man->user->name,
            'item_code'=>$this->way->item->codeno,
            'cash_amount'=>number_format($this->cash_amount),
            'bank_amount'=>number_format($this->bank_amount),
        ];
    }
}
