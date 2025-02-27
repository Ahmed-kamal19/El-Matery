<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Brand;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_brands');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $brand = request()->route('brand');

        return [
             'name_ar' => ['required','string',"unique:brands,name_ar,$brand->id",new NotNumbersOnly(),new ExistButDeleted(new Brand())],
             'name_en' => ['required','string',"unique:brands,name_en,$brand->id",new NotNumbersOnly(),new ExistButDeleted(new Brand())],
            'meta_keyword_ar' => 'nullable|string|max:255' ,
            'meta_keyword_en' => 'nullable|string|max:255' ,
            'meta_desc_en'    => 'nullable|string|max:255' ,
            'meta_desc_ar'    => 'nullable|string|max:255' ,
            'image'           => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:600' ,
            'cover'           => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:600' ,
        ];
    }
}
