<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Traits\NotificationTrait;

use App\Rules\NotNumbersOnly;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    use NotificationTrait;
    public function contact(Request $request)
    {

        $request->validate([

            'name'    => ['required' , 'string',new NotNumbersOnly],
            'phone' => ['required', 'string', 'regex:/^(05|5)\d{8}$/'],         
            'email'   => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        $data    = $request->toArray();
        $data['phone']   = '+966'.$request->phone;
        $contact = ContactUs::create($data);
        $this->newContactUsNotification($contact);
        return $this->success(data: $data);
    }
}
