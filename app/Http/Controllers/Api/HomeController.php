<?php

namespace App\Http\Controllers\Api;

 use App\Http\Controllers\Controller;
use App\Http\Resources\BrandHomeResource;
use App\Models\Brand;

 use App\Models\CarModel;
 use App\Models\Car;
 use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Resources\CarModelResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandSearchResource;
use App\Http\Resources\CarResource;
use App\Http\Resources\QuestionResource;

class HomeController extends Controller
{
    public function brands(){
         
        $brands = Brand::all();
        return   BrandHomeResource::collection($brands);


   }
   public function brandsSearch()
   {
        $brands = Brand::all();
        return BrandSearchResource::collection($brands);

   }

   public function modelsSearch($id)
   {
        
        $models=CarModel::where('brand_id',$id)->get()->map(function($item){
            return [
                'model_id'=>$item->id,
                'model_name'=>$item->name
            ];
        });
        if (!empty($models))
        {
            return $this->success(data:$models);
        }
        return $this->failure("No Models found");    
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
 public function normalSearch(Request $request)
 {
    $model_id = $request->input('model_id');
    $brand_id = $request->input('brand_id');
    $query = Car::query();
    if($model_id)
    {
        $query->where('model_id',$model_id);
    }
    if ($brand_id)
    {
        $query->where('brand_id',$brand_id);
    }
    $cars = $query->paginate(10);
    if(empty($cars))
    {
        return $this->failure("No cars found");
    }
    return $this->success(data:CarResource::collection($cars));
 }
 
 public function latestModel()
 {

     $cars=Car::orderBy('model_id','desc')
     ->orderBy('id','desc')->paginate(10);
     if(empty($cars))
     {
        return $this->failure("No cars found");
     } 
     return $this->success(data:CarResource::collection($cars));
 }

 public function exclusiveOffers()
 {
    $carOffers = Car::whereHas('offers',function($query){
        $query->where('status',1)->where('highlighted',1);
    })->paginate(10);
    if(empty($carOffers))
    {
        return $this->failure("No cars found");
    }
    return $this->success(data:CarResource::collection($carOffers));
 }
 public function advancedSearchCar(Request $request){
    $model_id = $request->input('model_id');
    $car_id = $request->input('car_id');
    $brand_id = $request->input('brand_id');
    $min_price = $request->input('min_price');
    $max_price = $request->input('max_price');

    $query = Car::query();

    if ($model_id) {
        $query->where('model_id', $model_id);
    }

    if ($brand_id) {
        $query->where('brand_id', $brand_id);
    }

    if ($car_id) {
        $query->where('id', $car_id);
    }

    if ($max_price && $min_price) {
        $query->whereBetween('price',[$min_price,$max_price]);
    }

    $results = $query->get();
    
    return $this->success(data:CarResource::collection($results));
}


public function getAllCars()
{
    
    $cars=Car::all();
    $res=$cars->map(function($car)
    {
        return [
            'id'=>$car->id,
            'car_name'=>$car->name.' '.$car->brand->name.' '.$car->model->name.' '.$car->year
        ];
    });
    if(empty($res))
    {
        return $this->failure("No cars found");
    }
    return $this->success(data:$res);
}
public function individualCashOrder(Request $request)
{

}
}
