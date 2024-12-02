<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Category;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
    
        return abilities()->contains('create_categories');
     }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => ['required','string',new NotNumbersOnly(),new ExistButDeleted(new Category())],
            'name_en'         =>['required','string',new NotNumbersOnly(),new ExistButDeleted(new Category())],
            'car_model_id'         => 'required|numeric' ,
            'meta_keyword_ar' => 'nullable|string|max:255' ,
            'meta_keyword_en' => 'nullable|string|max:255' ,
            'meta_desc_en'    => 'nullable|string|max:255' ,
            'meta_desc_ar'    => 'nullable|string|max:255' ,
        ];
    }
}
