<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PossibilityRequest;
use App\Models\Possibility;
class PossibilitiesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_news');

        if ($request->ajax())
        {

            $data = getModelData( model: new Possibility()  );

            return response()->json($data);
        }

        return view('dashboard.Possibility.index');
    }

public function create(){
         
     
    return view('dashboard.Possibility.create');
}

public function store(PossibilityRequest $request){
    Possibility::create($request->all());

    return redirect()->back();
}

public function edit($id){
    $possibility = Possibility::findOrFail($id);
    return view('dashboard.Possibility.edit',compact('possibility'));


}
public function show ($id){
    $possibility = Possibility::findOrFail($id);
    return view('dashboard.Possibility.show',compact('possibility'));


}
public function update(Request $request , Possibility $possibility){
    $possibility->update([
        'title_ar'=>$request->title_ar,
        'title_en'=>$request->title_en,
        'description_ar'=>$request->description_ar,
        'description_en'=>$request->description_en,
         'icon'=>$request->icon,
    ]);
$possibility->save();
return redirect()->back();

}
public function destroy($id){
    $possibility = Possibility::findOrFail($id);
    $possibility->delete();
    return view('dashboard.Possibility.index');


}
}
