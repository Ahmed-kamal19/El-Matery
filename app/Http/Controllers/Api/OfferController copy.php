<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarFavouriteResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OffersResource;

class OfferController extends Controller
{
    public function show($id)
    {
        try
        {
            $offer = Offer::find($id);
            //$cars=CarResource::collection($offer->cars);
              $data=[
                    'offers' =>  
                         
                    new OfferResource($offer),
                     
                   
               ];
        
          return $this->success(data: $data);
        } catch (\Exception $e)
        {
            return $this->failure(message: $e->getMessage());
        }
    }

    public function index(){

        
        $offers = Offer::where('status',1)->get();
        if($offers->isEmpty())
            return $this->success(data:null,message:"no data found");
    
    
        return $this->success(data:OffersResource::collection($offers));

        // $offers = Offer::with('cars')->paginate(4);  // Eager load cars with offers
       
        // // Pluck the cars for each offer in the paginated results
        // $cars = $offers->pluck('cars')->flatten();  // Flatten to combine into a single collection
        
        // // Return CarFavouriteResource collection
        // return CarFavouriteResource::collection($cars);
    }
}