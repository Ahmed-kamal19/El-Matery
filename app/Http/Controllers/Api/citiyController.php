<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class citiyController extends Controller
{
    //
    public function index(){
        $cities = City::get()->map(function($city){
            return [
                'id'=>$city->id,
                'name'=>$city->name
            ];
        });
        if($cities->isEmpty()) return $this->success(data:[],message:__("no data found"));
        return $this->success(data: $cities);

    }
}
