<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Tag;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_tags');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'    => ['required' , 'string' , 'max:255' , 'unique:tags',new NotNumbersOnly(),new ExistButDeleted(new Tag())],
            'name_en'    => ['required' , 'string' , 'max:255' , 'unique:tags',new NotNumbersOnly(),new ExistButDeleted(new Tag())],
            'bg_color'   => 'nullable | string | max:255',
        ];
    }
}
