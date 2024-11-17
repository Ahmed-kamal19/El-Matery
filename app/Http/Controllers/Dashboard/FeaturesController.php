<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;

class FeaturesController extends Controller
{
   
    public function index(Request $request)
    {
        $this->authorize('view_news');

        if ($request->ajax())
        {

            $data = getModelData( model: new Feature()  );

            return response()->json($data);
        }

        return view('dashboard.Feature.index');
    }

public function create(){
         
     
    return view('dashboard.Feature.create');
}

public function store(FeatureRequest $request){
    Feature::create($request->all());

    return redirect()->back();
}

public function edit($id){
    $feature = Feature::findOrFail($id);
    return view('dashboard.Feature.edit',compact('feature'));


}
public function show ($id){
    $feature = Feature::findOrFail($id);
    return view('dashboard.Feature.show',compact('feature'));


}
public function update(Request $request , Feature $feature){
    $feature->update([
        'title_ar'=>$request->title_ar,
        'title_en'=>$request->title_en,
        'description_ar'=>$request->description_ar,
        'description_en'=>$request->description_en,
         'icon'=>$request->icon,
    ]);
$feature->save();
return redirect()->back();

}
public function destroy($id){
    $feature = Feature::findOrFail($id);
    $feature->delete();
    return redirect()->route('dashboard.feature.index');


}

}
