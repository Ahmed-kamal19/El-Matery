<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
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
            'name'=> $this->name_ . getLocale() ,
            "meta_keyword"=> $this->meta_keyword_ . getLocale(),
             "meta_desc"=> $this->meta_desc_ . getLocale(),
            'brand'=>$this->brand->name
        ];    }
}
