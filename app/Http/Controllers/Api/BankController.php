<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks=Bank::all();
      
        if(!$banks->isEmpty())
        {
            
            return $this->success("success",data:BankResource::collection($banks));
        }
        return $this->failure("No data Exist");
    }
    public function bankSelection ()
    {
        $banks = Bank::all()->map(function($bank){
            return [
                'id'=>$bank->id,
                'name'=>$bank->name,
            ];
        });
        if(!$banks->isEmpty())
            return $this->success(data:$banks);
        return $this->success(data:[],message:__("no data found")) ;
    }
}
