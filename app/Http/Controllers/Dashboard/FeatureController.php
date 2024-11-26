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
    public function index(Request $request)
    {
        $this->authorize('view_features');

        if ($request->ajax()) {
            
            $features = getModelData(model: new Feature(), searchingColumns: ['title_ar', 'title_en','type','created_at']);
            return response()->json($features);
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
