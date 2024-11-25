<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\FeatureOrPossibility;
use App\Models\Feature;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFeatureRequest extends FormRequest
{
    
 
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_features');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
     
        return [
           
            'title_ar'    => ['required' , 'string' ,'unique:features', 'max:255' ,new NotNumbersOnly(),new ExistButDeleted(new Feature())],
            'title_en'    => ['required' , 'string' ,'unique:features', 'max:255' ,new NotNumbersOnly()],
            'icon'       => ['required' , 'file'   ,'image' ,'mimes:png,jpg,svg'],
            'type'       => ['required', Rule::in(array_keys(FeatureOrPossibility::values()))],
        ];
    }
}

