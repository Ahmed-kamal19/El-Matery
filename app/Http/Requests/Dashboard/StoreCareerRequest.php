<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Career;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreCareerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_careers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar'             => ['required', 'string', 'max:255', new NotNumbersOnly(),new ExistButDeleted(new Career())],
            'title_en'             => ['required', 'string', 'max:255', new NotNumbersOnly(),new ExistButDeleted(new Career())],
            'work_type'            => ['required', 'in:full-time,part-time,remotely'],
            // 'address'           => ['required','string','max:255'],
            // 'short_description' => ['required','string'],
            // 'long_description'  => ['required','string'],
            'city_id'           => ['required'],
        ];
    }
}
