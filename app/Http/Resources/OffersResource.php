<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CarResourse;
class OffersResource extends JsonResource
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
            "id"=>$this->id,
             "image"=>getImagePathFromDirectory($this->image,'Offers') ,
            //"cover"=> getImagePathFromDirectory($this->cover,'Offers'),
            "title"=> $this->title,
            "description"=> $this->description,
     

        ];

    }
}
