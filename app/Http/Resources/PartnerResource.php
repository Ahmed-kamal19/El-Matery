<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
        "image"=>            getImagePathFromDirectory($this->image, "Partners"),

        "created_at"=>$this->created_at->toDateString(),
        "updated_at"=>$this->updated_at->toDateString(),
        ];
    }
}
