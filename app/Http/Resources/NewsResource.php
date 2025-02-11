<?php

namespace App\Http\Resources;

use App\Models\News;
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
        $related_news=News::where('id','!=',$this->id)->get();
        
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description, // Assuming this is the translated attribute
            "highlighted_news" => $this->highlighted_news,
            'image'=>$this->main_image,
            "created_at" => $this->created_at->toDateString(),
            "related_news"=>RelatedNewsResource::collection($related_news)
        ];
    }
}
