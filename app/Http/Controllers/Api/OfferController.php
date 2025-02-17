<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OffersResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OfferController extends Controller
{
    public function show($id)
    {
        try
        {
            $offer = Offer::findOrFail($id);
            //$cars=CarResource::collection($offer->cars);
              $data=[
                    'offers' =>  
                         
                    new OfferResource($offer),
                     
                   
               ];
        
          return $this->success(data: $data);
        } catch (ModelNotFoundException $e)
        {
            return $this->failure(message:__("no data found"));
        }
    }

    public function index(){

        
        $offers = Offer::where('status',1)->get();
        if($offers->isEmpty())
            return $this->success(data:[],message:__("no data found"));
    
    
        return $this->success(data:OffersResource::collection($offers));


    }
}
