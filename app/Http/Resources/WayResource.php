<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Item;
use App\DeliveryMan;
use App\Http\Resources\ItemResource;
use App\Http\Resources\DeliveryManResource;

class WayResource extends JsonResource
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
            'item' =>new ItemResource(Item::find($this->item_id)),
            'delivery' =>new DeliveryManResource(DeliveryMan::find($this->delivery_man_id)),
        ];
    }
}
