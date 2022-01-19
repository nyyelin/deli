<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TownshipResource extends JsonResource
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
            'township_name' => $this->name,
            'delivery_fees'=>$this->delivery_fees,
        ];
    }
}
