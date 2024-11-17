<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    public function show($id)
    {
        try
        {
            $offer = Offer::find($id);
            $cars=CarResourse::collection($offer->cars);
              $data=[
                    'Offers' =>  
                         
                    new OfferResource($offer),
                     
                'fullPathImage'=>getImagePathFromDirectory($offer->image,'Offers'),
               ];
        
          return $this->success(data: $data);
        } catch (\Exception $e)
        {
            return $this->failure(message: $e->getMessage());
        }
    }

    public function index(){
        $offers = Offer::all();
        return OfferResource::collection($offers);


    }
}
