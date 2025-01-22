<?php

namespace App\Http\Resources;

use App\Enums\FeatureOrPossibility;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
    //    dd($this->discount_price);
        
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'price_before_discount'=>$this->price,
            'price'=>$this->discount_price ??0,
            'price_after_tax' => $this->getPriceAfterVatAttribute() == $this->price ? 0:$this->getPriceAfterVatAttribute(),
            'image'=>getImagePathFromDirectory($this->image,'Services'),
            'description'=>$this->description,
           
        ];
    }
}
