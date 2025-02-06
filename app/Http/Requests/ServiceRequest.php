<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name'=>'required',
            'phone' => ['required', 'numeric', 'regex:/^(05|5)\d{8}$/'],
            'car_brand'=>'required',
            'car_model'=>'required',
            'meter_reading'=>'required',
            'service_id'        => 'required|integer|exists:services,id',
            'city_id'           => 'required|integer|exists:cities,id',
        ];
    }
}
