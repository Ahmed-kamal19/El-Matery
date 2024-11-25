<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotUrl;
use App\Rules\youtubevalidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_settings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'website_name_ar' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            'website_name_en' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            // 'logo'                                             => ['required_if:setting_type,general', 'nullable', 'mimes:webp', 'max:2048'],
            // 'favicon'                                          => ['required_if:setting_type,general', 'nullable', 'mimes:webp', 'max:2048'],
            'facebook_url' => [ 'url', 'nullable', 'string', 'max:255'],
            'whatsapp_url' => ['url', 'nullable', 'string', 'max:255'],
            'twitter_url' => [ 'url', 'nullable', 'string', 'max:255'],
            'instagram_url' => [ 'url', 'nullable', 'string', 'max:255'],
            'youtube_url' => [ 'url', 'nullable', 'string', 'max:255'],
            'snapchat_url' => [ 'url', 'nullable', 'string', 'max:255'],
            'email' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            'phone' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            'tiktok' => [ 'nullable', 'string', 'max:255'],
            'address' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            'address_iframe' => ['required_if:setting_type,general', 'nullable', 'string'],
            'tax' => ['required_if:setting_type,general', 'numeric', 'between:0,100'],
            'insurance' => ['required_if:setting_type,calculator', 'numeric', 'between:0,100'],
            'profit_margin'=>['required_if:setting_type,calculator','numeric','between:0,100'],
            'administrative_fees'=>['required_if:setting_type,calculator','numeric','between:0,100'],
            'first_patch'=>['required_if:setting_type,calculator','numeric','between:0,100'],
            'last_payment'=>['required_if:setting_type,calculator','numeric','between:0,100'],
            'installment_years'=>['required_if:setting_type,calculator','integer'],
            //'females_insurance' => ['required_if:setting_type,general', 'numeric', 'between:0,100'],
            'maintenance_mode' => ['required_if:setting_type,general', 'nullable', 'string', 'max:255'],
            'orders_statuses' => ['required_if:setting_type,general', 'array'],
            'orders_statuses.*.name_ar' => ['required_if:setting_type,general'],
            'orders_statuses.*.name_en' => ['required_if:setting_type,general'],
            'orders_statuses.*.color' => ['required_if:setting_type,general'],
            'meta_tag_description_ar' => ['required_if:setting_type,seo', 'nullable', 'string', 'max:255'],
            'meta_tag_description_en' => ['required_if:setting_type,seo', 'nullable', 'string', 'max:255'],
            'meta_tag_keyword_ar' => ['required_if:setting_type,seo', 'nullable', 'string', 'max:255'],
            'meta_tag_keyword_en' => ['required_if:setting_type,seo', 'nullable', 'string', 'max:255'],
        
            'privacy_policy_ar' => ['required_if:setting_type,website', 'nullable', 'string'],
            'privacy_policy_en' => ['required_if:setting_type,website', 'nullable', 'string'],
            'terms_and_conditions_en' => ['required_if:setting_type,website', 'nullable', 'string'],
            'terms_and_conditions_ar' => ['required_if:setting_type,website', 'nullable', 'string'],
          
            //    'slider_ar'                                        => [ 'required_if:setting_type,website' ,'exists:revslider_sliders,alias'  ],
            //    'slider_en'                                        => [ 'required_if:setting_type,website' ,'exists:revslider_sliders,alias'  ],
            // 'financing_advantage_photo'                        => ['required_if:setting_type,about-website', 'nullable','mimes:webp', 'max:2048'],
           
            // 'about_us_video_url'                               => ['required_if:setting_type,about-website', 'nullable', 'string', 'max:255', new NotUrl],
        
            // 'why_code_car_section_card_1' => ['required_if:setting_type,about-website', 'nullable', 'string'],
          
            // 'setting_ar' => ['required_if:setting_type,about-website', 'nullable', 'string'],
            // 'setting_en' => ['required_if:setting_type,about-website', 'nullable', 'string'],
            // 'footer_text_ar' => ['required_if:setting_type,about-website', 'nullable', 'string', 'max:255'],
            // 'footer_text_en' => ['required_if:setting_type,about-website', 'nullable', 'string', 'max:255'],
        ];
    }
}
