<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\FeatureOrPossibility;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_tags');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $feature = request()->route('feature');
        return [
             'title_ar'    => ['required' , 'string' ,'unique:features,title_ar,' . $feature->id, 'max:255' ,new NotNumbersOnly()],
             'title_en'    => ['required' , 'string' ,'unique:features,title_en,' . $feature->id, 'max:255' ,new NotNumbersOnly()],
             'icon'        => ['nullable' , 'file'   ,'image' ,'mimes:png,jpg,svg','unique:features,icon,'.$feature->id,'max:4050'],
             'type'        => ['required', Rule::in(array_keys(FeatureOrPossibility::values()))],
        ];
    }
}
