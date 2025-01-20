<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id??null,
            'name'=>$this->name??null,
             'phone'=>$this->phone??null,
            'price'=>$this->price??0,
            'quantity'=>$this->quantity??1,
            'car_name'=>$this->car->name,
            'city'=>$this->city->name,
        ];
    }
}
