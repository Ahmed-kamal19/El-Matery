<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceDetailsResource;
use App\Http\Resources\ServiceResource;
use App\Models\City;
use App\Models\RequestService;
use App\Models\Service;
use App\Rules\NotNumbersOnly;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        
        $services = Service::all();
     
        if($services->isEmpty())
        {
            return $this->success(data:[],message:__("No services found"));
        }
        
        return $this->success(data:ServiceResource::collection($services));
    }
    public function show( $id)
    {
        try{
                $service=Service::findOrFail($id);
                return $this->success(data:new ServiceDetailsResource($service));
        }catch(ModelNotFoundException $e)
        {
            return $this->failure(message:__("no data found"));
        }
    }
    public function similarService(Service $service)
    {
        //$service->load('features'); // eager load to avoid N+1 query
        $featuresIds= $service->features->pluck('id')->toArray();
       // dd($featuresIds); 
        $similarServices= Service::whereHas('features',function($query) use ($featuresIds){
            $query->whereIn('features.id',$featuresIds);
        })->get();
        return response()->json([
            'data'=>ServiceResource::collection($similarServices)
        ]);
    }

    public function revieveCity()
    {   
        
        $cities = City::all();
        if(!$cities)
            return $this->success([],__('no cities found'));
        $cities = $cities->map(function($city){
            return [
                'id'=>$city->id,
                'name'=>$city->name
            ];
        });
        return $this->success(data:$cities);
    }
    
    // public function requestService(Request $request)
    // {
    //     $validatedData=$request->validate([
    //         'service_id'=>['required','exists:services,id'],
    //         'city_id'=>['required','exists:cities,id'],
    //         'name'=>['required','string', new NotNumbersOnly()],
    //         'phone' => ['required', 'string', 'regex:/^\+966(05|5)\d{8}$/'],
    //         'car_model'=>['required','string', new NotNumbersOnly()],
    //         'car_brand'=>['required','string', new NotNumbersOnly()]
    //     ]);

    //     RequestService::create($validatedData);
    //     return $this->success();
    // }

}
