<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\FeatureOrPossibility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreFeatureRequest;
use App\Http\Requests\Dashboard\UpdateFeatureRequest;
use App\Models\Feature;
use App\Rules\NotNumbersOnly;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeatureController extends Controller
{
    // public function index(Request $request)
    // {
    //     $this->authorize('view_features');

    //     if ($request->ajax()) {
            
    //         $features = getModelData(model: new Feature(), searchingColumns: ['title_ar', 'title_en','type','created_at']);
    //         return response()->json($features);
    //     }
    //     return view('dashboard.features.index');
    // }
    public function index(Request $request)
    {
        $this->authorize('view_features');
        $params = request()->all();
        
        if ($request->ajax()) {
            $data = Feature::query();
            if(isset($request->search['value'])){
                $searchKeyword =$request->search['value'];
                $data->where('title_ar','Like',"%$searchKeyword%")->orWhere('title_en','Like',"%$searchKeyword%");
             }
            
            
            // Check if there's a search value in column 5
            if (isset($request->columns[4]['search']['value'])) {
                $searchValue = $request->columns[4]['search']['value'];
    
                // If the search value is '1' or '2', filter by 'type'
                if ($searchValue == '1' || $searchValue == '2') {
                    $data->where('type', $searchValue);
                }
                // If '3' (All) is selected, do not apply any filter and return all features
                elseif ($searchValue == '3') {
                    // No need to apply a where clause for "All"
                }
            }

            if($request->columns[5]['search']['value']){
                $data->whereDate('created_at',$request->columns[5]['search']['value']);
            }
    
            // Prepare the response
            $response = [
                "recordsTotal" => $data->count(),
                "recordsFiltered" => $data->count(),
                'data' => $data->skip($params['start'])->take($params['length'])->get()
            ];
    
            return response()->json($response);
        }
    
        return view('dashboard.features.index');
    }

    public function create()
    {
        $this->authorize('create_features');
        return view('dashboard.features.create');
    }

    public function store(StoreFeatureRequest $request)
    {
     
        $this->authorize('create_features');
        $data = $request->validated();
        if($request->hasFile('icon'))
        {
            $data['icon'] = uploadImage( $request->file('icon') , "Icons");
        }
        Feature::create($data);
    }

    public function show($id)
    {
        abort(404);
    }

    public function edit(Feature $feature)
    {
        $this->authorize('update_features');
        return view('dashboard.features.edit', compact('feature'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        
        $this->authorize('update_features');

        $data = $request->validated();
        if($request->hasFile('icon'))
        {
            deleteImage($feature->icon,'Icons');
            $data['icon'] = uploadImage( $request->file('icon') , "Icons");
        }
        $feature->update($data);
    }

    public function destroy(Request $request, Feature $feature)
    {
        $this->authorize('delete_features');
        if ($request->ajax()) {
            $feature->delete();
        }
    }

    public function getOptions(Request $request)
    {

        $type = $request->input('type');
        $data = Feature::where('type',$type)->get();
       

        $options = [];
        if(!$data->isEmpty()){
            foreach ($data as $element)
            {
                 $options[$element->id]=$element->title;
            }
        }
        return response()->json(['options'=>$options]);
        
    }
}
