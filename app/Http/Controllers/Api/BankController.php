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
}
