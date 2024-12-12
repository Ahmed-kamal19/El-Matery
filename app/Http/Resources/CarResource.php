<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
        'id' => $this->id,
        "brand"=> $this->brand->name_.getLocale(),
        'name'=> $this->name_ . getLocale().' - '.$this->brand->name_.getLocale().' - '.$this->model->name_.getLocale() ,
        "price"=> $this->price,
        "discount_price"=>$this->discount_price,
        "price_after_vat"=>$this->price_after_vat,
        "fuel_type"=>__($this->fuel_type),
        "gear_shifter"=>__($this->gear_shifter),
        "year"=>$this->year
        // 'brand'=>$this->brand->name
        ];
    
    }
}
