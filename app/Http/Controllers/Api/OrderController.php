<?php

namespace App\Http\Controllers\Api;
use TaqnyatSms;

use App\Models\Car;
use App\Models\Order;
use App\Models\CarOrder;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CompanyOrderResource;
use App\Rules\NotNumbersOnly;
use App\Traits\NotificationTrait;
use App\Models\Otp;
use Exception;

use Illuminate\Validation\ValidationException;


class OrderController extends Controller
{

    use NotificationTrait;
    private function sendOtp(Request $request , $phone , $order)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],
        ]);
    
        $numbers = range(1, 100); // Create an array of numbers from 1 to 100
        shuffle($numbers); // Shuffle the array
        $otp = '1234';
    
        $uniqueNumbers = array_slice($numbers, 0, 4); // Get the first 4 numbers from the shuffled array
        // foreach ($uniqueNumbers as $number) {
        //     $lastDigit = $number % 10; // Get the last digit of the number
        //     $otp .= $lastDigit; // Append the last digit to the OTP
        // }

    
        // Ensure that the $phone being passed is used correctly, don't overwrite it
     
        // $bearer  = "8dee4f4224cbda8486d62a0e75f2194b" ;
        // $taqnyt = new TaqnyatSms($bearer);
        
        $checkOtps = Otp::where('phone',$phone)->get();
        foreach($checkOtps as $checkOtp){
            $checkOtp->delete();
        } 
 


        // Create the OTP record in the database
     Otp::create([
            'phone' => '+966' . $phone,  // Use the phone number passed to the function
            'otp' => $otp,
             'order_id' => $order,
        ]);
        $sender = "Nasser Matar El-Mutairi";
        $body = App()->getLocale() == 'ar' ? 'تم ارسال طلبك بنجاح الي شركة ناصر مطر المطيري برجاء ادخال رمز التحقق  : ' . $otp: 'Thank you for registering. Our verification code is : ' . $otp;
        // $message = $taqnyt->sendMsg($body, $phone, $sender);
 
     

        return $body;



       
    }
    private function distribute($order_id)
    {

        // Get all employees with the required role
        $employees = Employee::where('email', '!=', 'support@webstdy.com')
            ->whereHas('roles.abilities', function ($query) {
                $query->where('name', 'view_order_received');
            })
            ->get();
   
        $employeeCount = $employees->count();
          
        if ($employeeCount > 0) {
            // Get the current order
            $order = Order::find($order_id);
            
            if (!$order) {
                return; // Exit if order doesn't exist
            }
    
            // Find the employee with the least recent assignment
            $lastAssignedEmployee = Order::whereNotNull('employee_id')
                ->orderBy('updated_at', 'desc')
                ->first();
    
            // Determine the next employee in round-robin order
            $lastEmployeeIndex = $lastAssignedEmployee
                ? $employees->pluck('id')->search($lastAssignedEmployee->employee_id)
                : -1; // Start with -1 if no orders are assigned yet
    
            $nextEmployeeIndex = ($lastEmployeeIndex + 1) % $employeeCount;
    
           
            // Assign the order to the next employee
            $order->update(['employee_id' => $employees[$nextEmployeeIndex]->id]);
            $this->newOrderNotification($order,$employees[$nextEmployeeIndex]->id);

        }
    }
  
  
 


    public function index(Request $request)
    {

       

        $orders = Order::all();
           
        return response()->json($orders);
    }

    public function individualsFinance(Request $request)
    {
     
         $request->validate([
            'name'=>['required','string'],
            'car_id'=>['required','integer','exists:cars,id'],
            
             'salary'=>['required','integer'],
             'year'=>['required','integer'],
            'city_id'=>['required','integer','exists:cities,id'], 
            'first_payment_value'=>['required','numeric'],
            'last_payment_value'=>['required','numeric'],
            'bank_id'=>['required','integer','exists:banks,id'],
            'work'=>['required','string',new NotNumbersOnly()],
            'color_id'    => ['required','exists:colors,id'],
            'stumbles' => ['required', 'in:0,1'], // Only accepts 0 or 1
            
            'commitments'    => ['required', 'numeric'],
            
            'having_loan'    =>['required', 'in:0,1'], //قرض عقاري
            
            'driving_license' => ['required', Rule::in(['available', 'expired', 'doesnt_exist'])],
            
            'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],
            
        ]);
  
    
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
                 'phone' => '+966'. $request->phone,            
                'car_id' => $request->car_id,
                'city_id' => $request->city_id,
                'price' => $car->price_after_vat,
                'status_id' => 8,
                'color_id' => $request->color_id,//

                'car_name'=>$car->name,
            ]);
    
            $this->distribute($order->id);
            $otp = $this->sendOtp($request, $request->phone,$order->id);

            $carOrder = CarOrder::create([
                'type' => 'individual',
                'payment_type' => 'finance',
                'salary' => $request->salary,
                'year' => $request->year,
                'first_payment_value' => $request->first_payment_value,
                'last_payment_value' => $request->last_payment_value,
                'commitments' => $request->commitments,
                'bank_id' => $request->bank_id,
                'work' => $request->work,
                'order_id' => $order->id, 
                'having_loan' => $request->having_loan,//
                'driving_license' => $request->driving_license,

            ]);
    
     // return response 
    return response()->json([
        'message'=>'success',
        'data'=>new OrderResource($order),
        'otp'=>$otp,
    ]);
    
    
       
    }

    public function individualsCash(Request $request)
{
    $request->validate([
        'car_id'=>['required','integer','exists:cars,id'],
        'color_id'    => ['required','exists:colors,id'],
        'organization_seo'=>['required','string',new NotNumbersOnly()],
        'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],

        'city_id'=>['required','integer','exists:cities,id'],
 

       
    ]);
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
    'color_id' => $request->color_id,
     'car_name'=>$car->name,
     'phone' => '+966'. $request->phone,
    'price' => $car->price_after_vat,
    'name' => $request->organization_seo,
    'status_id' => 8,
     
]);
$this->distribute($order->id);
$otp = $this->sendOtp($request, $request->phone,$order->id);

$carOrder = CarOrder::create([
    'type' => 'individual',
    'payment_type' => 'cash',
     'organization_seo' => $request->organization_seo,


 

  
    
    'order_id' => $order->id, 

    
]);




return response()->json([
    'message'=>'success',
    'data'=>$order,
    'otp'=>$otp

]);


}
    
public function companyFinance(Request $request)
{
    $request->validate([
        'first_payment_value'=>['required','numeric'],
        'last_payment_value'=>['required','numeric'],
        'car_id'=>['required','integer','exists:cars,id'],
        'color_id'    => ['required','exists:colors,id'],
        'quantity'=>['required','numeric'],
        'organization_name'=>['required','string',new NotNumbersOnly()],
        'organization_activity'=>['required','string',new NotNumbersOnly()],
        'organization_location'=>['required','string',new NotNumbersOnly()],
        'organization_seo'=>['required','string',new NotNumbersOnly()],
        'year'=>['required','integer'],

        'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],
        'bank_id'=>['required','integer','exists:banks,id'],

     ]);
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
    'quantity' => $request->quantity,
    'car_name'=>$car->name,
    'price' => $car->price_after_vat * $request->quantity,
    'name' => $request->organization_seo,
    'color_id' => $request->color_id,
    'phone' => '+966' . $request->phone,
    'status_id' => 8,
     
]);
$this->distribute($order->id);
$otp = $this->sendOtp($request, $request->phone,$order->id);

$carOrder = CarOrder::create([
    'type' => 'organization',
    'payment_type' => 'cash',
    'first_payment_value' => $request->first_payment_value,
    'last_payment_value' => $request->last_payment_value,
    'organization_name' => $request->organization_name,
    'organization_activity' => $request->organization_activity,
    'organization_location' => $request->organization_location,
    'organization_seo' => $request->organization_seo,


    'bank_id' => $request->bank_id,
    'year' => $request->year,


  
    
    'order_id' => $order->id, 

    
]);




return response()->json([
    'message'=>'success',
    'data'=>$order,
    'otp'=>$otp

]);

}


public function companyCash(Request $request)
{
   
    $request->validate([
        'car_id'=>['required','integer','exists:cars,id'],
        'color_id'    => ['required','exists:colors,id'],
        'quantity'=>['required','numeric'],
        'organization_name'=>['required','string',new NotNumbersOnly()],
        'organization_activity'=>['required','string',new NotNumbersOnly()],
        'organization_location'=>['required','string',new NotNumbersOnly()],
        'organization_seo'=>['required','string',new NotNumbersOnly()],
        
        
        
        'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],
        'bank_id'=>['required','integer','exists:banks,id'],
 
    ]);
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
        'color_id' => $request->color_id,
        'car_name'=>$car->name,
        'phone' =>'+966' . $request->phone,
        'quantity' => $request->quantity,
        'price' => $request->quantity * $car->price_after_vat,
        'status_id' => 8,
        
    ]);
$this->distribute($order->id);

    $otp = $this->sendOtp($request, $request->phone,$order->id);

    $carOrder = CarOrder::create([
        'type' => 'organization',
        'payment_type' => 'cash',
        'organization_name'=>$request->organization_name,
        'organization_activity' => $request->organization_activity,

        'organization_location' => $request->organization_location,
        'organization_seo' => $request->organization_seo,
        'order_id'=>$order->id,
        'bank_id'=>$request->bank_id



    ]);



    return response()->json([
        'message'=>'success',
        'data'=>$order,
        'otp'=>$otp
    ]);


}


    

// public function serviceOrder(Request $request)
// {
//     $request->validate([
//         ''
//     ])
// }

}
