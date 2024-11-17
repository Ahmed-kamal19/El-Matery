<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
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
            "id" => $this->id,
            "title" => $this->title,
            "short_description" => $this->short_description,
            "long_description" => $this->long_description,
            "address" => $this->address,
            'city' => [
                'id' => $this->city->id,
                'title' => $this->city->name,
            ],
            "work_type" => $this->work_type,
            "created_at" => $this->created_at->toDateString(),
            "updated_at" => $this->updated_at->toDateString(),
        ];    }
}
