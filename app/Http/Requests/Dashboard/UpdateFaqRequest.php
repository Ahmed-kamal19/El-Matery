<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_faq');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $faq = request()->route('faq');

        return [
            'question_ar' => ['required', 'string', 'max:255', "unique:faqs,question_en,$faq->id", new NotNumbersOnly()],
            'question_en' => ['required', 'string', 'max:255', "unique:faqs,question_en,$faq->id", new NotNumbersOnly()],
            'answer_ar' => ['required', 'string', new NotNumbersOnly()],
            'answer_en' => ['required', 'string', new NotNumbersOnly()],
        ];
    }
}
