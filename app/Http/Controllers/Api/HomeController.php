<?php

namespace App\Http\Controllers\Api;

 use App\Http\Controllers\Controller;
 use App\Models\Brand;

 use App\Models\CarModel;
 use App\Models\Car;
 use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Resources\CarModelResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\QuestionResource;

class HomeController extends Controller
{
    public function brands(){
         
        $brands = Brand::all();
        return   BrandResource::collection($brands);


   }

   public function cars(){

       $cars = Car::all();
       return new CarResourse($cars);
       // return $this->success('successfully',$cars);

}

public function models(){ 
        
   $model = CarModel::all();
   return   CarModelResource::collection($model);

}
public function getAllData(){
    $data = [];

    $brands = Brand::with('models')->get();
    $cars = Car::all();
    $models = CarModel::all();
    
    
    
    $data['brands'] = BrandResource::collection($brands);
    $data['cars'] = CarResourse::collection($cars);
    $data['models'] = CarModelResource::collection($models);

    return response()->json($data);
}
public function questions(){ 
        
    $questions = Question::all();
    return   QuestionResource::collection($questions);
 
 }
 
// public function carSearch(Request $request){
//     return 's';
//    $model_id = $request->input('model_id');
//    $car_id = $request->input('car_id');
//    $brand_id = $request->input('brand_id');

//    $query = Car::query();

//    if ($model_id) {
//        $query->where('model_id', $model_id);
//    }

//    if ($brand_id) {
//        $query->where('brand_id', $brand_id);
//    }
//    if ($car_id) {
//        $query->where('id', $car_id);
//    }
//    $results = $query->get();

//    return response()->json([
//     'data'=>CarResourse::collection($results),

//    ]
//     );
// }

}
