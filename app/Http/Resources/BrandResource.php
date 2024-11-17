<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            "car_available_types"=> $this->car_available_types,
            "keyword"=> $this->meta_keyword_ . getLocale(),
             "meta_desc"=> $this->meta_desc_ . getLocale(),
            'created_at' => $this->created_at->format('Y-m-d'),
            "updated_at"=>  $this->updated_at->format('Y-m-d'),
            "deleted_at"=>  $this->deleted_at ?$this->deleted_at->format('Y-m-d'): null,
            "cars_count"=> $this->cars->count(),

        ];    }
}
