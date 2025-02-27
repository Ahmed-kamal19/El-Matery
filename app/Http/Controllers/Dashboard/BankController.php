<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreBankRequest;
use App\Http\Requests\Dashboard\UpdateBankRequest;
use App\Models\Bank;
use App\Models\Sector;
use App\Rules\NotNumbersOnly;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_banks');
        if ($request->ajax()){
             return response()->json(getModelData(model: new Bank() ));
            //  return response()->json(getModelData(model : new Bank() , andsFilters: [['type', '=', 'bank']],));
        }
       return view('dashboard.banks.index');
    }

    public function create()
    {
        $this->authorize('create_banks');
       
        return view('dashboard.banks.create');
    }

    public function store(StoreBankRequest $request)
    {

        $this->authorize('create_banks');

        $data = $this->validateRequestData();
        $data['image'] = uploadImage( $request->file('image') ,"Banks");
        Bank::create($data);
    }

    public function validateRequestData()
    {
        $ValidationArray = [
            'image'      => 'required|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'name_ar' => ['required','string','unique:banks',new NotNumbersOnly()],
            'name_en' => ['required','string','unique:banks',new NotNumbersOnly()],
            'type' => ['required']
        ];
        return request()->validate($ValidationArray);
    }

    public function edit(Bank $bank)
    {
        $this->authorize('update_banks');
        return view('dashboard.banks.edit',compact('bank'));
    }

    public function show($id)
    {
        abort(404);
    }

    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $this->authorize('update_banks');

        $data = $this->validateRequestForEditing($bank->id);
        $data['image'] = $this->updateImage($bank->image);
        $bank->update($data);
        
    }

    public function validateRequestForEditing($bankId)
    {
        $ValidationArray = [
            'image'      => 'mimes:jpeg,jpg,png,gif,svg,webp|max:600',
            'name_ar' => ['required','string','unique:banks,name_ar,'. $bankId,new NotNumbersOnly()],
            'name_en' => ['required','string','unique:banks,name_en,'. $bankId,new NotNumbersOnly()],
            'type' => ['required']
        ];
        return request()->validate($ValidationArray);
    }

    public function updateImage($imageName)
    {
        if (request()->hasFile('image')) {
            deleteImage($imageName, "Banks");
            return uploadImage(request()->file('image'), "Banks");
        } else {
            return $imageName;
        }
    }

    public function destroy(Request $request, Bank $bank)
    {
        $this->authorize('delete_banks');

        if($request->ajax())
        {
            $bank->delete();
        }
    }
}
