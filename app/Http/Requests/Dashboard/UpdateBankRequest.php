<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Bank;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_banks');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $bank = request()->route('bank');

        return [
            'name_ar'    => ['required' , 'string' , 'max:255' , 'unique:banks,name_ar,' . $bank->id,new NotNumbersOnly(),new NotNumbersOnly(),new ExistButDeleted(new Bank())],
            'name_en'    => ['required' , 'string' , 'max:255' , 'unique:banks,name_en,' . $bank->id,new NotNumbersOnly(),new NotNumbersOnly(),new ExistButDeleted(new Bank())],
            'image'      => 'nullable|mimes:webp|max:600'
        ];
    }
}
