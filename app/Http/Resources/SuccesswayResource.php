<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\DeliveryManResource;
use App\Item;
use App\DeliveryMan;
class SuccesswayResource extends JsonResource
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
            'item_id' => $this->item_id,
            'status_code'=>$this->status_code,
            'item'=>new ItemResource(Item::find($this->item_id)),
            'delivery_man' => new DeliveryManResource(DeliveryMan::find($this->delivery_man_id)),
            'delivery_date'=>$this->delivery_date,
        ];
    }
}
