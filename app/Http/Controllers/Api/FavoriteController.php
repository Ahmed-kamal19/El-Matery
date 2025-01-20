<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\StoreFavoriteRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFavoriteRequest $request)
    {
         $ip=$request->ip();
         $existingCarIds = Car::whereIn('id', $request->car_ids)->pluck('id')->toArray();
         $deletedCarIds  = array_diff($request->car_ids,$existingCarIds);
         $favorites = Favorite::whereIn('car_id', $existingCarIds)->where(function ($query) {
            $query->where('device_ip', request()->ip());
        })
        ->get();
        
         if (!$favorites->isEmpty()) {
            Favorite::whereIn('car_id', $existingCarIds)
            ->where('device_ip', $ip)
            ->delete();
         $carUnFavoriteData = Car::whereIn('id', $existingCarIds)->get();

            return $this->success(data:['unavailiable_ids'=>array_values($deletedCarIds),'cars'=>CarResource::collection($carUnFavoriteData)]);
        } else {
            $request['device_ip']=$request->getClientIp(); 
            $data = array_map(function ($carId) use ($request) {
                return [
                    'car_id' => $carId,
                    'device_ip' => $request->ip(),
                   // 'vendor_id' => Auth::user()->id ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $request->car_ids);
            
            $favorites=Favorite::insert($data);
            $carFavoriteData = Car::whereIn('id',$existingCarIds)->get();
            return $this->success(data: ['unavailiable_ids'=>array_values($deletedCarIds),'cars'=>CarResource::collection($carFavoriteData)]);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
