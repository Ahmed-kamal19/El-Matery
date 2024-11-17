<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_cars');

        if ($request->ajax())
        {

            $data = getModelData( model: new Question()  );

            return response()->json($data);
        }

        return view('dashboard.Questions.index');
    }
    public function create(){
         
     
        return view('dashboard.Questions.create');
    }
    public function store(QuestionRequest $request){
        Question::create($request->all());

        return redirect()->back();
    
     
        return view('dashboard.Questions.create');
    }
    


    public function show(Question $question){

    }
    public function edit(Question $question){
        return view('dashboard.Questions.edit',compact('question'));

    }
    public function update(Request $request , Question $question){
        $question->update([
            'question_ar'=>$request->question_ar,
            'question_en'=>$request->question_en,
            'answer_ar'=>$request->answer_ar,
            'answer_en'=>$request->answer_en,
         ]);
    $question->save();
    return redirect()->back();
    
    }
    public function destroy($id){
        $question = Question::findOrFail($id);
        $question->delete();
        return view('dashboard.Questions.index');
    
    
    }
    
}
