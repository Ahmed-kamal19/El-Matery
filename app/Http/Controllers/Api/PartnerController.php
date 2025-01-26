<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Http\Resources\PartnerResource;

class PartnerController extends Controller
{
     public function index(){
         
        $partners = Partner::all();
        return   PartnerResource::collection($partners);

         
     }
}
