<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandHomeResource extends JsonResource
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
            'id' => $this->id,
            'name'=>$this->name,
            "image"=>getImagePathFromDirectory($this->image, 'Brands'),
            "cover"=>getImagePathFromDirectory($this->cover, 'Brands'),
            "cars_count"=> $this->cars->count(),

        ];
    }
}
