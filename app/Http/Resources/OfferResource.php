<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CarResource;
class OfferResource extends JsonResource
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
            "id"=>$this->id ,
            "image"=>getImagePathFromDirectory($this->image,'Offers') ,
            // "cover"=> getImagePathFromDirectory($this->cover,'Offers'),
            "title"=> $this->title_ . getLocale(),
            "description_ar"=> $this->description_ . getLocale(),
            "status"=>$this->status == 1 ?'available':'unavailable',
            "highlighted"=> $this->highlighted,
            "created_at"=> $this->created_at->toDateString(),
            "updated_at"=> $this->updated_at->toDateString(),
            "car"=>
                CarResource::collection($this->cars),
            

        ];

    }
}
