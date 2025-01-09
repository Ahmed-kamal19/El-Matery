<?php

namespace App\Http\Resources;

use App\Enums\FeatureOrPossibility;
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

        $features= $this->features->filter(function($feature){
            return $feature->type === FeatureOrPossibility::feature->value; 
        })
        ->map(function ($feature) {
            return [
                'id' => $feature->id,
                'title'=> $feature->title,
                'description' => $feature->pivot->description,
                'icon' => getImagePathFromDirectory($feature->icon,'Icons'),
                

            ];
        })->toArray();
        $possibilities= $this->features->filter(function($feature){
            return $feature->type === FeatureOrPossibility::posibility->value; 
        })
        ->map(function ($feature) {
            return [
                'id' => $feature->id,
                'title'=> $feature->title,
                'description' => $feature->pivot->description,
                'icon' => getImagePathFromDirectory($feature->icon,'Icons'),
                

            ];
        })->toArray();
       
  
        
        return [  
        'id'=>$this->id,
        'name'=>$this->name,
        'price'=>$this->price,
        'price_after_tax' => $this->getPriceAfterVatAttribute(),
        'image'=>getImagePathFromDirectory($this->image,'Services'),
        'description'=>$this->description,
        'features'=>$features,
        'possibilities'=>$possibilities
        ];
    }
}
