@extends('partials.dashboard.master')
@section('content')
    <!--begin::Card-->
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10 mt-0"
        style="background-size: auto  calc(100% + 10rem); background-position: {{ isArabic() ? 'left' : 'right' }} ; background-image: url('{{ asset('dashboard-assets/media/illustrations/sketchy-1/4.png') }}')">
        <!--begin::Card header-->
        <div class="p-6">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-circle me-5">
                    <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs020.svg-->
                        <span>
                            <i class="bi bi-gear-fill fs-1 text-primary"></i>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <h2>{{ __('settings') }}</h2>
                </div>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pb-0">
           
            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6  setting-label active" id="general-settings-label"
                            href="javascript:" onclick="changeSettingView('general')">{{ __('General') }}</a>
                    </li>
                    <!--end::Nav item-->

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 setting-label" id="seo-settings-label"
                            href="javascript:" onclick="changeSettingView('seo')">{{ __('Seo') }}</a>
                    </li>
                    <!--end::Nav item-->

                    <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 setting-label" id="website-settings-label"
                            href="javascript:" onclick="changeSettingView('website')">{{ __('Website') }}</a>
                    </li>
                    <!--end::Nav item-->

                

                </ul>
            </div>
            <!--begin::Navs-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <!--begin::Form-->
    <form action="{{ route('dashboard.settings.store') }}" class="form" method="post" id="submitted-form"
        data-redirection-url="{{ route('dashboard.settings.index') }}">
        @csrf

        <!-- Begin :: General Settings Card -->
        <input type="hidden" name="setting_type" value="general" id="setting-type-inp">

        <!-- Begin :: General Settings Card -->
        <div class="card card-flush setting-card" id="general-settings-card">
            <!--begin::Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>{{ __('General') }}</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-general">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>
            </div>
            <!--end::Card header-->

            <!-- Begin :: Card body -->
            <div class="card-body">
                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Website name in arabic') }}</label>
                        <input type="text" class="form-control" name="website_name_ar"
                            value="{{ settings()->getSettings('website_name_ar') ?? '' }}" id="website_name_ar_inp"
                            placeholder="{{ __('Enter the website name in arabic') }}">
                        <p class="invalid-feedback" id="website_name_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Website name in english') }}</label>
                        <input type="text" class="form-control" name="website_name_en"
                            value="{{ settings()->getSettings('website_name_en') ?? '' }}" id="website_name_en_inp"
                            placeholder="{{ __('Enter the website name in english') }}">
                        <p class="invalid-feedback" id="website_name_en"></p>

                    </div>
                    <!-- End   :: Col -->


                    <!-- End   :: Col -->
                    <div class="col-md-4 fv-row">
                        <label class="fs-5 fw-bold mb-2">{{ __('Phone') }}</label>
                        <div class="input-group mb-5">
                            <input type="text" class="form-control" value="{{ settings()->getSettings('phone') }}"
                                id="phone_inp" name="phone" placeholder="{{ __('Enter the phone') }}" />
                            <p class="invalid-feedback" id="phone"></p>
                        </div>
                    </div>

                </div>
                <!-- End   :: Input group -->
                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Facebook') }}</label>
                        <input type="text" class="form-control" name="facebook_url"
                            value="{{ settings()->getSettings('facebook_url') ?? '' }}" id="facebook_url_inp"
                            placeholder="{{ __('Enter the facebook page url') }}">
                        <p class="invalid-feedback" id="facebook_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Twitter') }}</label>
                        <input type="text" class="form-control" name="twitter_url"
                            value="{{ settings()->getSettings('twitter_url') ?? '' }}" id="twitter_url_inp"
                            placeholder="{{ __('Enter the twitter page url') }}">
                        <p class="invalid-feedback" id="twitter_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Snapchat') }}</label>
                        <input type="text" class="form-control" name="snapchat_url"
                            value="{{ settings()->getSettings('snapchat_url') ?? '' }}" id="snapchat_url_inp"
                            placeholder="{{ __('Enter the snapchat url') }}">
                        <p class="invalid-feedback" id="snapchat_url"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Instagram') }}</label>
                        <input type="text" class="form-control" name="instagram_url"
                            value="{{ settings()->getSettings('instagram_url') ?? '' }}" id="instagram_url_inp"
                            placeholder="{{ __('Enter the instagram page url') }}">
                        <p class="invalid-feedback" id="instagram_url"></p>
                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Youtube') }}</label>
                        <input type="text" class="form-control" name="youtube_url"
                            value="{{ settings()->getSettings('youtube_url') ?? '' }}" id="youtube_url_inp"
                            placeholder="{{ __('Enter the youtube channel url') }}">
                        <p class="invalid-feedback" id="youtube_url"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Whatsapp') }}</label>
                        <input type="text" class="form-control" name="whatsapp_url"
                            value="{{ settings()->getSettings('whatsapp_url') ?? '' }}" id="whatsapp_url_inp"
                            placeholder="{{ __('Enter the whatsapp url') }}">
                        <p class="invalid-feedback" id="whatsapp_url"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">
                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="text" class="form-control" name="email"
                            value="{{ settings()->getSettings('email') ?? '' }}" id="email_inp"
                            placeholder="{{ __('Enter the email') }}">
                        <p class="invalid-feedback" id="email"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-4">

                        <label class="form-label">{{ __('Tiktok') }}</label>
                        <input type="text" class="form-control" name="tiktok"
                            value="{{ settings()->getSettings('tiktok') ?? '' }}" id="tiktok_inp"
                            placeholder="{{ __('Enter the tiktok page url') }}">
                        <p class="invalid-feedback" id="tiktok"></p>

                    </div>
                    <!-- End   :: Col -->
                      <!-- Begin :: Col -->
                      <div class="col-md-4">

                        <label class="form-label">{{ __('LinkedIn') }}</label>
                        <input type="text" class="form-control" name="linkedIn"
                            value="{{ settings()->getSettings('linkedIn') ?? '' }}" id="linkedIn_inp"
                            placeholder="{{ __('Enter the linkedIn page url') }}">
                        <p class="invalid-feedback" id="linkedIn"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin location :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" class="form-control" name="address"
                            value="{{ settings()->getSettings('address') ?? '' }}" id="address_inp"
                            placeholder="{{ __('Enter the address') }}">
                        <p class="invalid-feedback" id="address"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" class="form-control" name="address_iframe"
                            value="{{ settings()->getSettings('address_iframe') ?? '' }}" id="address_iframe_inp"
                            placeholder="{{ __('Enter the address') }}">
                        <p>{{ __('example') }}: <span
                                class="text-danger fw-bolder">{{ '<iframe src="https://www.google.com/maps/.." ></iframe>' }}</span>
                        </p>
                        <p class="invalid-feedback" id="address_iframe"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->
                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Tax in percentage') }}</label>
                        <input type="text" class="form-control" name="tax"
                            value="{{ settings()->getSettings('tax') ?? '' }}" id="tax_inp"
                            placeholder="{{ __('Enter the tax in percentage') }}">
                        <p class="invalid-feedback" id="tax"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <div class="d-flex justify-content-between align-items-center mt-12">

                            <label class="form-label">{{ __('Tax active') }}</label>

                            <div class="form-check form-check-custom form-check-solid my-auto">
                                <input class="form-check-input" type="radio" value="1" name="maintenance_mode"
                                    id="active-radio-btn"
                                    {{ settings()->getSettings('maintenance_mode') == '1' ? 'checked' : '' }} />
                                <label class="form-check-label me-10" for="active-radio-btn"> {{ __('active') }}
                                </label>

                                <input class="form-check-input" type="radio" value="0" name="maintenance_mode"
                                    id="inactive-radio-btn"
                                    {{ settings()->getSettings('maintenance_mode') == '0' ? 'checked' : '' }} />
                                <label class="form-check-label" for="inactive-radio-btn"> {{ __('inactive') }} </label>
                            </div>

                        </div>
                        <p class="invalid-feedback" id="maintenance_mode"></p>


                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->
             
               


                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('logo') }}</label>
                        <br>
                        <input type="file" class="d-none" accept="image/*" name="logo" id="logo-uploader">
                        <button class="btn btn-secondary w-100 image-upload-inp" type="button"> <i
                                class="bi bi-upload fs-8"></i>
                            {{ settings()->getSettings('logo') ?: __('no file is selected') }}
                        </button>
                        <p class="invalid-feedback" id="logo"></p>


                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('favicon') }}</label>
                        <br>
                        <input type="file" class="d-none" accept="image/*" name="favicon" id="favicon-uploader">
                        <button class="btn btn-secondary w-100 image-upload-inp" type="button"> <i
                                class="bi bi-upload fs-8"></i>
                            {{ settings()->getSettings('favicon') ?: __('no file is selected') }} </button>
                        <p class="invalid-feedback" id="favicon"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-12">

                        <label class="form-label">{{ __('orders statuses') }}</label>
                        <br>
                        <!--begin::Repeater-->
                        <div id="form_repeater">
                            <!--begin::Form group-->
                            <input type="text" hidden name='deletedstatus[]' id='deletedStatusInput'>
                            <div class="form-group">
                                <div data-repeater-list="orders_statuses">
                                    @foreach ($orderStatuses ?? [] as $status)
                                        <div data-repeater-item>
                                            <div class="form-group row mt-5">
                                                <input type="text" name="id" value="{{ $status['id'] }}" hidden>
                                                <div class="col-md-3">
                                                    <label
                                                        class="form-label status-order">{{ $loop->iteration . ' - ' . __('Name in arabic') }}</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0"
                                                        name="name_ar" {{ $loop->first ? 'readonly' : '' }}
                                                        value="{{ $status['name_ar'] }}"
                                                        placeholder="{{ __('Enter status name in arabic') }}" />
                                                    <p class="invalid-feedback"
                                                        id="orders_statuses_{{ $loop->index }}_name_ar"></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">{{ __('Name in english') }}</label>
                                                    <input type="text" class="form-control mb-2 mb-md-0"
                                                        name="name_en" {{ $loop->first ? 'readonly' : '' }}
                                                        value="{{ $status['name_en'] }}"
                                                        placeholder="{{ __('Enter status name in english') }}" />
                                                    <p class="invalid-feedback"
                                                        id="orders_statuses_{{ $loop->index }}_name_en"></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">{{ __('status color') }}</label>
                                                    <input type="color" name="color" class="form-control"
                                                        placeholder="{{ __('Enter status color') }}"
                                                        value="{{ $status['color'] }}" style="height:47.5px" />
                                                    <p class="invalid-feedback"
                                                        id="orders_statuss_{{ $loop->index }}_color"></p>
                                                </div>

                                                <div class="col-md-3 text-center">
                                                    <a href="javascript:" data-repeater-delete
                                                        onclick="deleteId('{{ $status['id'] }}')"
                                                        class="btn btn-sm btn-light-danger mt-4 mt-md-9">
                                                        <i class="la la-trash-o"></i>{{ __('Delete') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:" data-repeater-create class="btn btn-light-primary">
                                    <i class="la la-plus"></i>{{ __('Add') }}
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->



                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: General Settings Card -->


        <!-- Begin :: Seo Settings Card -->
        <div class="card card-flush setting-card" style="display:none" id="seo-settings-card">
            <!--begin::Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>Seo</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-seo">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>

            </div>
            <!--end::Card header-->

            <!-- Begin :: Card body -->
            <div class="card-body">

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Meta tag description in arabic') }}</label>
                        <textarea class="form-control form-control form-control" name="meta_tag_description_ar"
                            id="meta_tag_description_ar_inp" data-kt-autosize="true">{{ settings()->getSettings('meta_tag_description_ar') ?? '' }}</textarea>
                        <p class="invalid-feedback" id="meta_tag_description_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Meta tag description in english') }}</label>
                        <textarea class="form-control form-control form-control" name="meta_tag_description_en"
                            id="meta_tag_description_en_inp" data-kt-autosize="true">{{ settings()->getSettings('meta_tag_description_en') ?? '' }}</textarea>
                        <p class="invalid-feedback" id="meta_tag_description_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Meta tag keywords in arabic') }}</label>
                        <input type="text" class="" id="meta_tag_keyword_ar_inp" name="meta_tag_keyword_ar"
                            value="{{ settings()->getSettings('meta_tag_keyword_ar') ?? '' }}"
                            placeholder="{{ __('Enter the meta tag keywords in arabic') }}" />
                        <p class="invalid-feedback" id="meta_tag_keyword_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Meta tag keywords in english') }}</label>
                        <input type="text" class="" id="meta_tag_keyword_en_inp" name="meta_tag_keyword_en"
                            value="{{ settings()->getSettings('meta_tag_keyword_ar') ?? '' }}"
                            placeholder="{{ __('Enter the meta tag keywords in english') }}" />
                        <p class="invalid-feedback" id="meta_tag_keyword_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: Seo Settings Card -->


        <!-- Begin :: Website Settings Card -->
        <div class="card card-flush setting-card" style="display:none" id="website-settings-card">

            <!-- Begin :: Card header-->
            <div class="card-header pt-8">

                <div class="card-title">
                    <h2>{{ __('Website') }}</h2>
                </div>

                <div class="card-title">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary mx-4" id="submit-btn-website">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>

            </div>
            <!-- End   :: Card header-->
            <!-- Begin :: Card body -->
            <div class="card-body">

                 <!-- Begin :: Input group -->
                 <div class="fv-row row mb-15">
                      <!-- begin :: Row -->
                      <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column align-items-center">
                                <!-- begin :: Upload image component -->
                              
                                <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                <div>
                                    <x-dashboard.upload-image-inp name="image_about_us" :image="settings()->getSettings('image_about_us')" directory="Settings"
                                        placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>

                                </div>
                                <p class="invalid-feedback" id="image"></p>
                                <!-- end   :: Upload image component -->
                            </div>

                            <div class="d-flex flex-column align-items-center">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Cover') }}</label>
                                <div>
                                    <x-dashboard.upload-image-inp name="cover_about_us" :image="settings()->getSettings('cover_about_us')" directory="Settings"
                                        placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                </div>
                                <p class="invalid-feedback" id="cover"></p>
                                <!-- end   :: Upload image component -->
                            </div>

                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->
                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('About us in arabic') }}</label>
                      
                        <textarea id="tinymce_about_us_ar" name="about_us_ar" class="tinymce">{!! settings()->getSettings('about_us_ar') ?? '' !!}</textarea>


                        <p class="text-danger invalid-feedback" id="about_us_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('About us in english') }}</label>
                      
                        <textarea id="tinymce_about_us_en" name="about_us_en" class="tinymce">{!! settings()->getSettings('about_us_en') ?? '' !!}</textarea>


                        <p class="text-danger invalid-feedback" id="about_us_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->
                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Privacy policy in arabic') }}</label>
                        <textarea id="tinymce_privacy_policy_ar" name="privacy_policy_ar" class="tinymce">{!! settings()->getSettings('privacy_policy_ar') ?? '' !!}</textarea>

                        <p class="text-danger invalid-feedback" id="privacy_policy_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Privacy policy in english') }}</label>
                        <textarea id="tinymce_privacy_policy_en" name="privacy_policy_en" class="tinymce">{!! settings()->getSettings('privacy_policy_en') ?? '' !!}</textarea>

                        <!--<textarea rows="2" class="form-control form-control form-control" name="privacy_policy_en"-->
                        <!--    data-kt-autosize="true">{!! settings()->getSettings('privacy_policy_en') ?? '' !!}</textarea>-->
                        <p class="text-danger error-element" id="privacy_policy_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->
                <!-- Begin :: Input group -->
                <div class="fv-row row mb-15">

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Terms and conditions in arabic') }}</label>
                        <!--<textarea rows="2" class="form-control form-control form-control" name="terms_and_conditions_ar"-->
                        <!--    data-kt-autosize="true">{!! settings()->getSettings('terms_and_conditions_ar') ?? '' !!}</textarea>-->
                        <textarea id="tinymce_terms_and_conditions_ar" name="terms_and_conditions_ar" class="tinymce">{!! settings()->getSettings('terms_and_conditions_ar') ?? '' !!}</textarea>


                        <p class="text-danger invalid-feedback" id="terms_and_conditions_ar"></p>

                    </div>
                    <!-- End   :: Col -->

                    <!-- Begin :: Col -->
                    <div class="col-md-6">

                        <label class="form-label">{{ __('Terms and conditions in english') }}</label>

                        <!--<textarea rows="2" class="form-control form-control form-control" name="terms_and_conditions_en"-->
                        <!--    data-kt-autosize="true">{!! settings()->getSettings('terms_and_conditions_en') ?? '' !!}</textarea>-->
                        <textarea id="tinymce_terms_and_conditions_en" name="terms_and_conditions_en" class="tinymce">{!! settings()->getSettings('terms_and_conditions_en') ?? '' !!}</textarea>



                        <p class="text-danger invalid-feedback" id="terms_and_conditions_en"></p>

                    </div>
                    <!-- End   :: Col -->

                </div>
                <!-- End   :: Input group -->

            </div>
            <!-- End   :: Card body -->

        </div>
        <!-- End   :: Website Settings Card -->


    

    </form>
    <!--end::Form-->
@endsection
@push('scripts')
    <script>
        let deletedIds = [];

        function deleteId(itemId) {
            // Add the deleted ID to the array
            deletedIds.push(itemId);
            // Perform any other deletion logic if needed
            console.log(deletedIds);
            // Remove the deleted item from the DOM
            // You may need to adjust this based on your structure
            // Here, I'm assuming you're using the repeater functionality
            // provided by Livewire's `data-repeater`

            // Update the value of the deletedstatus[] input field
            const deletedstatusInput = document.getElementById('deletedStatusInput');

            const deletedIdsString = deletedIds.join(',');

            deletedstatusInput.value = deletedIdsString;

        }
    </script>
    <script src="{{ asset('dashboard-assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/form_repeater.js') }}"></script>
    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    {{--  <script>
        tinymce.init({
            selector: "#about_us_ar_inp",
            height: "480",
            menubar: false,
            toolbar: ["styleselect fontselect fontsizeselect",
                "undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify",
                "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"
            ],
            plugins: "advlist autolink link image lists charmap print preview code"
        });
    </script>  --}}
    <script>
        tinymce.init({
            selector: '#tinymce_privacy_policy_ar',
            plugins: 'directionality', // Include the directionality plugin
            {{--  toolbar: 'ltr rtl', // Add LTR and RTL buttons to the toolbar  --}}
            toolbar: ["styleselect",
                "undo redo | cut copy paste | bold italic | link  | alignleft aligncenter alignright alignjustify|numlist bullist",
                "bullist numlist| ltr rtl | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code"
            ],
            {{--  toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl', // Add LTR and RTL buttons  --}}
            directionality: 'rtl', // Set the initial direction to RTL if needed
            // Add any additional TinyMCE configuration here
            height: 480, // Example height setting
            menubar: false, // Example menu bar setting
        });
    </script>
    <script>
        let changeSettingView = (tab) => {

            $('.setting-card').hide();
            $('.setting-label').removeClass('active');

            $("#" + tab + '-settings-card').show()
            $("#" + tab + '-settings-label').addClass('active')

            $("#setting-type-inp").val(tab);
        };

        $(document).ready(() => {

            initTinyMc(true);

            $('.image-upload-inp').click(function() {

                $(this).prev().trigger('click');

            });

            $('[id*=-uploader]').change(function() {

                let fileName = $(this)[0].files[0].name;

                $(this).next().html(`<i class="bi bi-upload fs-8" ></i> ${ fileName } `);

            });

            new Tagify(document.getElementById('meta_tag_keyword_ar_inp'), {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });
            new Tagify(document.getElementById('meta_tag_keyword_en_inp'), {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });


        });
    </script>
@endpush
