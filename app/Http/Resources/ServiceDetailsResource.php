<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

      
        
        return [  
        'id'=>$this->id,
        'name'=>$this->name,
        'price'=>$this->price,
        'price_after_tax' => $this->getPriceAfterVatAttribute(),
        'image'=>getImagePathFromDirectory($this->image,'Services'),
        'description'=>$this->description,
        ];
    }
}
