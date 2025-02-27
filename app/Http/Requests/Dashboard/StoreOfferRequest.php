<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Offer;
use App\Rules\ExistButDeleted;
use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_offers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar'          => ['required','string','max:255','unique:offers',new NotNumbersOnly(),new ExistButDeleted(new Offer())],
            'title_en'          => ['required','string','max:255','unique:offers',new NotNumbersOnly(),new ExistButDeleted(new Offer())],
            'description_ar'    => ['required','string'],
            'description_en'    => ['required','string'],
            'cars'              => ['required','array','min:1'],
            'image'             => ['required','mimes:jpeg,png,jpg,webp,svg','max:600'],
        ];
    }
}
