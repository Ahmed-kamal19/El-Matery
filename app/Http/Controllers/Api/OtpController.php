<?php

namespace App\Http\Controllers\Api;

use TaqnyatSms;
use App\Models\Otp;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{
    public function validOtp(Request $request)
    {

        // Validate the phone number format
        $request->validate([
            'otp' => 'required|digits:4',
            'phone' => ['required', 'string', 'regex:/^\+966(05|5)\d{8}$/'],
            'orderId' => 'required',

        ]);

        $orderId = $request->orderId;

        $code = Otp::where('phone', $request->phone)
            ->first();


        if ($code->otp == $request->otp) {
            $order = Order::find($orderId);
            $order->update(
                ['status_id' => '1']
            );
            $code->delete();
            return response()->json([
                'message' => 'successfully'
            ]);
        } else {

            $msg = App()->getLocale() == 'ar' ? 'رمز التحقق غير صحيح' : 'OTP is incorrect';

            return response()->json([

                'error' => $msg,
            ], 400);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+966(05|5)\d{8}$/'],
            'orderId' => 'required',


        ]);

        $numbers = range(1, 100); // Create an array of numbers from 1 to 100
        shuffle($numbers); // Shuffle the array
        $otp = '';

        $uniqueNumbers = array_slice($numbers, 0, 4); // Get the first 4 numbers from the shuffled array
        foreach ($uniqueNumbers as $number) {
            $lastDigit = $number % 10; // Get the last digit of the number
            $otp .= $lastDigit; // Append the last digit to the OTP
        }

        // Ensure that the $phone being passed is used correctly, don't overwrite it
        //    $bearer = 'e78f50db9da68bd56d7c4c5b2be85f7d';
        //    $taqnyt = new TaqnyatSms($bearer);
        $orderId = $request->orderId;

        $otpsExcit = Otp::where('phone', $request->phone)->get();

        if ($otpsExcit)
        // Create the OTP record in the database
        {
            foreach ($otpsExcit as $otpExcit) {
                # code...
                $otpExcit->delete();
            }



            Otp::create([
                'phone' =>  $request->phone,  // Use the phone number passed to the function
                'otp' => $otp,
                'order_id' => $orderId,
            ]);
        } else {
            Otp::create([
                'phone' =>  $request->phone,  // Use the phone number passed to the function
                'otp' => $otp,

                'order_id' => $orderId,

            ]);
        }

        // Send the SMS
        $body = App()->getLocale() == 'ar' ? 'تم ارسال طلبك بنجاح الي شركة قطاف برجاء ادخال رمز التحقق  : ' . $otp : 'Thank you for registering. Our verification code is : ' . $otp;
        $bearer  = "8dee4f4224cbda8486d62a0e75f2194b" ;

        $sender = "QitafMotors";
        $taqnyt = new TaqnyatSms($bearer);

           $message = $taqnyt->sendMsg($body, $request->phone, $sender);

        return response()->json([
            'otp' => $body,
        ], 200);
    }
}
