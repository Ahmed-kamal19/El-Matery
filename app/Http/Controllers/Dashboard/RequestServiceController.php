<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RequestService;
use Illuminate\Http\Request;

class RequestServiceController extends Controller
{
    
    public function index(Request $request){

        // $this->authorize('view_services');

        if ($request->ajax())
        {
            $data = getModelData(model: new RequestService(), relations: [
                
                'service' => ['id', 'name_' . getLocale(),'description_en','description_ar'] ,
                'city' => ['id', 'name_' . getLocale() ],
                'status'=>['id','name_'.getLocale()],
            
            
            
            
            ]);

 
             return response()->json($data);
        }
        return view("dashboard.services.request");
    }
}
