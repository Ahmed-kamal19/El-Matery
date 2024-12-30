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

        $similar_services = Service::where('id','!=',$this->id)->take(6)->get();
        
        return [  
        'id'=>$this->id,
        'name'=>$this->name,
        'price'=>$this->price,
        'price_after_tax' => $this->getPriceAfterVatAttribute(),
        'image'=>getImagePathFromDirectory($this->image,'Services'),
        'description'=>$this->description,
        'similar_services'=>!$similar_services->isEmpty() ? ServiceResource::collection($similar_services) : null
        ];
    }
}
