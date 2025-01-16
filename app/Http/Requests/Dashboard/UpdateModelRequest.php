<?php

namespace App\Http\Requests\Dashboard;

use App\Models\CarModel;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_models');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => ['required','string',new NotNumbersOnly(),new ExistButDeleted(new CarModel())],
            'name_en' => ['required','string',new NotNumbersOnly(),new ExistButDeleted(new CarModel())],
            'meta_keyword_ar' => 'nullable|string|max:255' ,
            'meta_keyword_en' => 'nullable|string|max:255' ,
            'meta_desc_en'    => 'nullable|string|max:255' ,
            'meta_desc_ar'    => 'nullable|string|max:255' ,
            'brand_id'        => 'required',
        ];
    }
}
