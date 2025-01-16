<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    private static array $relations = [
        'Car'                   => ['brand'    => ['id' , 'name_ar','name_en' ] ],
        'Order'                 => ['employee' => ['id','name']],
    ];

    public function index($modelName = 'Car')
    {
        $this->authorize('view_recycle_bin');
 
        if ( request()->ajax() ) {

            $model = app('App\\Models\\' . $modelName);
            $data = getModelData( model: $model , relations: TrashController::$relations[$modelName], onlyTrashed: true );

            return  response()->json($data);
        }

        return view('dashboard.trash');
    }


    public function forceDelete($modelName, $id)
    {
        $this->authorize('delete_recycle_bin');
       
        $modelClass = 'App\\Models\\' . $modelName;
        if (!class_exists($modelClass)) {
            abort(404, 'Model not found.');
        }

        // Get the model instance with soft-deleted records
        $model = $modelClass::onlyTrashed()->find($id);
        if (!$model) {
            abort(404, 'Record not found in recycle bin.');
        }

        // Handle specific model types
        if ($modelName === 'Car') {
            if ($model->main_image) {
                deleteImage($model->main_image, 'Cars');
            }
        } elseif ($modelName === 'Order') {
            if ($model->Insurance_Image) {
                deleteImage($model->Insurance_Image, 'Orders');
            }
            if ($model->Hr_Letter_Image) {
                deleteImage($model->Hr_Letter_Image, 'Orders');
            }
        }

        // Force delete the record
        $model->forceDelete();

    }

    public function restore($modelName, $id)
    {
        $this->authorize('restore_recycle_bin');
        
        $model = app('App\\Models\\' . $modelName);
        $resultRestore=$model->onlyTrashed()->find($id)->restore();
       
        if($modelName == "CarModel" && $resultRestore)
        {
            
            return redirect()->route('dashboard.models.index');

        }
        else if($modelName == "Category" && $resultRestore)
        {
            
            return redirect()->route('dashboard.categories.index');

        }
      
        else if($modelName == "City" && $resultRestore)
        {
            
            return redirect()->route('dashboard.cities.index');

        }
      
        else if($modelName == 'Car')
        {
            $car = $model->find($id);
         
          
           ( new CarController)->storeBrandCarsTypeCount($car['is_new'], $car['brand_id']);
        }
        else if($modelName =='Branch' && $resultRestore)
        {
            return redirect()->route( 'dashboard.branches.index' );
        }
        else
        {

            $dynamicRoute = 'dashboard.' . lcfirst($modelName) . 's.index';
            return redirect()->route(  $dynamicRoute);
        }

    }

}
