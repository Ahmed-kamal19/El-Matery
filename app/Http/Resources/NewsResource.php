<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            "description" => $this->description, // Assuming this is the translated attribute
            "highlighted_news" => $this->highlighted_news,
            "highlighted_image" => getImagePathFromDirectory($this->highlighted_image, 'News'),
            "main_image" => getImagePathFromDirectory($this->main_image, 'News'),
            "created_at" => $this->created_at->toDateString(),
        ];
    }
}
