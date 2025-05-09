<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_news');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar' => ['required', 'string', 'max:255',new NotNumbersOnly()],
            'title_en' => ['required', 'string', 'max:255',new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'main_image' => ['nullable', 'mimes:jpeg,png,jpg,webp,svg', 'max:600'],
           
        ];
    }
}
