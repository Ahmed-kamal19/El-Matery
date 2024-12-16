<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use App\Models\Order;
use App\Models\CarOrder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndividualOrderCashRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CompanyOrderResource;
use Illuminate\Validation\ValidationException;


class OrderController extends Controller
{
    public function index(Request $request)
    {

       

        $orders = Order::all();
           
        return response()->json($orders);
    }

    public function individualsFinance(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $car = Car::select('id', 'price', 'name_' . getLocale())
                ->where('id', $request->car_id)
                ->first();
    
            if (!$car) {
                throw ValidationException::withMessages([
                    'car_id' => __("You must select a car")
                ]);
            }
    
            $order = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'car_id' => $request->car_id,
                'city_id' => $request->city_id,
                'price' => $car->price,
                'status_id' => 2,
                'stumbles'=>$request->stumbles,
                'car_name'=>$car->name_ . getLocale(),
            ]);
    
            $carOrder = CarOrder::create([
                'type' => 'individual',
                'payment_type' => 'finance',
                'salary' => $request->salary,
                'commitments' => $request->commitments,
                'first_payment_value' => $request->first_payment_value,
                'last_payment_value' => $request->last_payment_value,
                'bank_id' => $request->bank_id,
                'work' => $request->work,
                'order_id' => $order->id,
                'driving_license' => $request->driving_license,
            ]);
    
            DB::commit();
     // return response 
    return response()->json([
        'message'=>'success',
        'data'=>new OrderResource($order),
    ]);
    
    
        } catch (\Exception $e) {
            DB::rollBack();
            // Handle the exception here
        }
    }

    public function individualsCash(IndividualOrderCashRequest $request)
{
    
    $car = Car::select('id', 'price', 'name_' . getLocale())
    ->where('id', $request->car_id)
    ->first();

if (!$car) {
    throw ValidationException::withMessages([
        'car_id' => __("You must select a car")
    ]);
}

$order = Order::create([
    'car_id' => $request->car_id,
    'car_name'=>$car->name_ . getLocale(),
    'price' => $car->price,
    'name' => $request->name,
    'phone' => $request->phone,
     
]);
return response()->json([
    'message'=>'success',
    'data'=>$order
]);


}
    
public function companyFinance(Request $request)
{
    try {
        DB::beginTransaction();

        $car = Car::select('id', 'price', 'name_' . getLocale())
            ->where('id', $request->car_id)
            ->first();

        if (!$car) {
            throw ValidationException::withMessages([
                'car_id' => __("You must select a car")
            ]);
        }
        $order = Order::create([
            'car_name'=>$car->name_ . getLocale(),
            'car_id' => $request->car_id,
            'phone' => $request->phone,
            'quantity' => $request->quantity,
            'status_id' => 2,
            'price' => $request->quantity * $car->price,

       



        ]);
        $carOrder = CarOrder::create([
            'type' => 'organization',
            'payment_type' => 'finance',
            'organization_name' => $request->organization_name,
            'organization_email' => $request->organization_email,
            'organization_location' => $request->organization_location,
            'order_id' => $order->id,
            'bank_id' => $request->bank_id,
            'organization_activity' => $request->organization_activity,
            'organization_seo' => $request->organization_seo,


 
        ]);

        DB::commit();
         // return response 
return response()->json([
    'message'=>'success',
 ]);


    } catch (\Exception $e) {
        DB::rollBack();
        // Handle the exception here
    }
}


public function companyCash(Request $request)
{
    $car = Car::select('id', 'price', 'name_' . getLocale())
    ->where('id', $request->car_id)
    ->first();

if (!$car) {
    throw ValidationException::withMessages([
        'car_id' => __("You must select a car")
    ]);
}

$order = Order::create([
    'car_id' => $request->car_id,
    'car_name'=>$car->name_ . getLocale(),
    'phone' => $request->phone,
    'quantity' => $request->quantity,
    'price' => $request->quantity * $car->price,
    
]);

$carOrder = CarOrder::create([
    'type' => 'organization',
    'payment_type' => 'cash',
    'organization_name'=>$request->organization_name,
    'organization_email' => $request->organization_email,

    'organization_seo' => $request->organization_seo,



]);



return response()->json([
    'message'=>'success',
    'data'=>$order
]);


}
    



}
