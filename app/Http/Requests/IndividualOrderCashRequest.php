<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndividualOrderCashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string'],
            'phone' => ['bail', 'required', 'regex:/^((\+|00)966|0)?5[0-9]{8}$/'],
            'color_id'=>['required','exists:car_color_images,color_id'],
            'car_id'=>['required','exists:cars,id'],
        ];
    }
}
