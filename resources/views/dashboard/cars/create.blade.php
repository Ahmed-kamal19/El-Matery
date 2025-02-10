    @extends('partials.dashboard.master')
    @push('styles')
        <link href="{{ asset('dashboard-assets/css/wizard' . (isArabic() ? '.rtl' : '') . '.css') }}" rel="stylesheet"
            type="text/css" />

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">

        <style>
            .separator-dashed {
                border-color: #e4e6ef !important;
            }
        </style>

    @endpush
    @section('content')
        <!-- begin :: Subheader -->
        <div class="toolbar">

            <div class="container-fluid d-flex flex-stack">

                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                    <!-- begin :: Title -->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                            href="{{ route('dashboard.cars.index') }}"
                            class="text-muted text-hover-primary">{{ __('Cars') }}</a></h1>
                    <!-- end   :: Title -->

                    <!-- begin :: Separator -->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!-- end   :: Separator -->

                    <!-- begin :: Breadcrumb -->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!-- begin :: Item -->
                        <li class="breadcrumb-item text-muted">
                            {{ __('Add new car') }}
                        </li>
                        <!-- end   :: Item -->
                    </ul>
                    <!-- end   :: Breadcrumb -->

                </div>

            </div>

        </div>
        <!-- end   :: Subheader -->

        <!-- begin :: Card -->
        <div class="card">

            <div class="card-body p-0">

                <!-- begin :: Wizard Body -->
                <div class="card card-custom card-shadowless rounded-top-0">

                    <div class="card-body p-0">

                        <div class="row justify-content-center pt-8">
                            <div class="col-xl-12">


                <!-- begin :: Wizard Body -->
                <div class="card card-custom card-shadowless rounded-top-0">

                                <form class="form mt-0 mt-lg-10" id="submitted-form" enctype="multipart/form-data">

                                    <input class="d-none" type="file">
                                    <!--begin::Form-->

                                    <!--end::Form-->
                                    <!-- begin :: Row -->
                                    <div class="row mb-10">
                                     <label class="text-center fw-bold mb-4">{{ __('Image') }}</label>
                                     <div class="col-md-12 fv-row d-flex justify-content-evenly">
                                        <x-dashboard.upload-image-inp name="car_Image" :image="null" :directory="null" 
                                            placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                            
                                        </div>
                                        <p class="fv-plugins-message-container invalid-feedback text-center mt-2" id="car_Image"></p>
                                        <!-- end   :: Upload image component -->
                                        
                                    </div>
                                    <!-- end   :: Row -->

                                    <div class="p-8">

                                        <!-- begin :: Row -->
                                        <div class="row mb-10">

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label for="brand-sp" class=" fs-5 fw-bold mb-2">{{ __('Brand') }}</label>
                                                <select class="form-select" data-control="select2" name="brand_id"
                                                    id="brand-sp" data-placeholder="{{ __('Choose the brand') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected></option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"> {{ $brand->name }} </option>
                                                    @endforeach
                                                </select>
                                                <p class="invalid-feedback" id="brand_id"></p>
                                            </div>
                                            <!-- end   :: Column -->

                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('Model') }}</label>
                                                <select class="form-select" data-control="select2" name="model_id"
                                                    id="model-sp" data-placeholder="{{ __('Choose the model') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected></option>
                                                    @if (isset($models))
                                                        @foreach ($models as $model)
                                                            <option value="{{ $model->id }}"> {{ $model->name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="invalid-feedback" id="model_id"></p>
                                            </div>
                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('city data') }}</label>
                                                <select class="form-select" data-control="select2" name="city_id" id="city-sp"
                                                    data-placeholder="{{ __('Choose the city') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected></option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"> {{ $city->name }} </option>
                                                    @endforeach
                                                </select>
                                                <p class="invalid-feedback" id="city_id"></p>
                                            </div>

                                        </div>
                                        <!-- end   :: Row -->


                                    <div class="p-8">

                                        <!-- begin :: Row -->
                                        <div class="row mb-10">

                                            <div class="col-md-3 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Category') }}</label>
                                                <select class="form-select" data-control="select2" name="category_id"
                                                    id="category-sp" data-placeholder="{{ __('Choose the category') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected></option>
                                                    @if (isset($categories))
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"> {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="invalid-feedback" id="category_id"></p>
                                            </div>

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('Car name in arabic') }}</label>

                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name_ar_inp"
                                                        name="name_ar" placeholder="example" />
                                                    <label for="name_ar_inp">{{ __('Car name in arabic') }}</label>
                                                </div>

                                                <p class="invalid-feedback" id="name_ar"></p>

                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('Car name in english') }}</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name_en_inp"
                                                        name="name_en" placeholder="example" />
                                                    <label for="name_en_inp">{{ __('Car name in english') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="name_en"></p>



                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">


                                                <label class=" fs-5 fw-bold mb-2">{{ __('Year') }}</label>
                                                <select class="form-select" data-control="select2" name="year"
                                                    data-placeholder="{{ __('Choose the year') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected></option>
                                                    @for ($year = Date('Y') + 1; $year >= 2000; $year--)
                                                        <option value="{{ $year }}"> {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <p class="invalid-feedback" id="year"></p>

                                            </div>
                                            <!-- end   :: Column -->

                                        </div>
                                        <!-- end   :: Row -->

                                        <!-- begin :: Row -->
                                        <div class="row mb-10">

                                            <!-- begin :: Column -->
                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('fuel type') }}</label>

                                                <select class="form-select" data-control="select2" name="fuel_type"
                                                    data-placeholder="{{ __('Choose the fuel type') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    <option value="" selected>{{ __('Choose the fuel') }}</option>
                                                    <option value="gasoline">{{ __('gasoline') }}</option>
                                                    <option value="diesel">{{ __('diesel') }}</option>
                                                    <option value="electric">{{ __('electric') }}</option>
                                                    <option value="hybrid">{{ __('hybrid') }}</option>
                                                </select>
                                                <p class="invalid-feedback" id="fuel_type"></p>


                                            </div>
                                            <!-- end   :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Video url') }}</label>

                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="video_url_inp"
                                                        name="video_url" placeholder="example" />
                                                    <label for="video_url_inp">{{ __('Enter the video url') }}</label>
                                                </div>

                                                <p class="invalid-feedback" id="video_url"></p>

                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('Price') }}</label>
                                                <div class="form-floating">
                                                    <input type="number" min="1" class="form-control" id="price_inp"
                                                        name="price" placeholder="example" />
                                                    <label for="price_inp">{{ __('Enter the price') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="price"></p>



                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-3 fv-row">


                                                <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                                                    <label class="fs-5 fw-bold">{{ __('Discount price') }}</label>
                                                    <input class="form-check-input mx-2" style="height: 18px;width:36px;"
                                                        type="checkbox" name="have_discount" id="discount-price-switch" />
                                                    <label class="form-check-label" for="flexSwitchChecked"></label>
                                                </div>

                                                <div class="form-floating">
                                                    <input type="number" min="1" class="form-control"
                                                        id="discount_price_inp" name="discount_price" disabled
                                                        placeholder="example" />
                                                    <label
                                                        for="discount_price_inp">{{ __('Enter the discount price') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="discount_price"></p>


                                            </div>
                                            <!-- end   :: Column -->

                                        </div>
                                        <!-- end   :: Row -->

                                        <!-- begin :: Column -->
                                        <div class="row mb-10">
                                            <div class="col-md-4 fv-row">

                                                <label class=" fs-5 fw-bold mb-2">{{ __('fuel tank capacity') }}</label>
                                                <div class="form-floating">
                                                    <input type="number" min="30" class="form-control"
                                                        id="fuel_tank_capacity_inp" name="fuel_tank_capacity"
                                                        placeholder="example" />
                                                    <label
                                                        for="fuel_tank_capacity_inp">{{ __('Enter the fuel tank capactiy in liters') }}</label>
                                                </div>
                                                <p class="invalid-feedback" id="fuel_tank_capacity"></p>


                                            </div>
 
                                           
                                            <!-- begin :: Column -->
                                            <div class="col-md-4 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __('Tags') }}</label>
                                                <select class="form-select" data-control="select2" name="tags[]" multiple
                                                    id="tags-sp" data-placeholder="{{ __('Choose the tags') }}"
                                                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag['id'] }}"> {{ $tag['name'] }} </option>
                                                    @endforeach

                                                </select>
                                                <p class="invalid-feedback" id="tags"></p>
                                            </div>

                                        </div>
                                        <!-- end   :: Column -->

                                        <!-- begin :: Row -->
                                        <div class="row mb-10">

                                            <!-- begin :: Column -->
                                            <div class="col-md-6 fv-row">
                                                <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                                                <div class="form-floating">

                                                    <textarea class="form-control" rows="4" name="description_ar" id="description_ar_inp"
                                                        data-kt-autosize="true"></textarea>
                                                    <label
                                                        for="description_ar_inp">{{ __('Enter description in Arabic') }}</label>

                                                </div>
                                                <p class="text-danger invalid-feedback" id="description_ar"></p>
                                            </div>
                                            <!-- end   :: Column -->

                                            <!-- begin :: Column -->
                                            <div class="col-md-6 fv-row">
                                                <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                                                <div class="form-floating">
                                                    <textarea class="form-control" rows="4" name="description_en" id="description_en_inp"data-kt-autosize="true"></textarea>
                                                    <label
                                                        for="description_en_inp">{{ __('Enter description in English') }}</label>
                                                </div>
                                                <p class="text-danger invalid-feedback" id="description_en"></p>
                                                <!-- end   :: Column -->

                                            </div>

                                            <div class="row">

                                                <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="Supplier" name="supplier"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'Gulf',
                                                                'value' => 'gulf',
                                                                'id' => 'supplier_gulf',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'Saudi',
                                                                'value' => 'saudi',
                                                                'id' => 'supplier_saudi',
                                                                'checked' => false,
                                                            ],
                                                        ]" />


                                                </div>
                                                <!-- end   :: Column -->


                                            </div>
                                            <!-- end   :: Row -->
                                            <div class="separator separator-dashed my-4"></div>
                                            <!-- Begin :: Row -->
                                            <div class="row">

                                             <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="price_field_status" name="price_field_status"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'Show details',
                                                                'value' => '1',
                                                                'id' => 'showDetails',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'Competitive price',
                                                                'value' => '2',
                                                                'id' => 'competitivePrice',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'Available upon request',
                                                                'value' => '3',
                                                                'id' => 'availableUponRequest',
                                                                'checked' => false,
                                                            ], 
                                                            [
                                                                'label' => 'unavailable',
                                                                'value' => '4',
                                                                'id' => 'unavailable',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'others',
                                                                'value' => '5',
                                                                'id' => 'others',
                                                                'checked' => false,
                                                            ],
                                                        ]" />

                                                            
                                                </div>

                                                <!-- end   :: Column -->

                                            </div>
                                            <div id="otherInputs" style="display:none">
                                                <div class="col-md-6 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">{{ __('Description in arabic') }}</label>
                                                    <div class="form-floating">
                                                        <textarea class="form-control" rows="4" name="other_description_ar" id="other_description_ar_inp"data-kt-autosize="true"></textarea>
                                                        <label
                                                            for="other_description_ar_inp">{{ __('Enter description in Arabic') }}</label>
                                                    </div>
                                                    <p class="text-danger invalid-feedback" id="other_description_ar"></p>
                                                    <!-- end   :: Column -->
    
                                                </div>
                                                <div class="col-md-6 fv-row">
                                                    <label class="fs-5 fw-bold mb-2">{{ __('Description in english') }}</label>
                                                    <div class="form-floating">
                                                        <textarea class="form-control" rows="4" name="other_description_en" id="other_description_en_inp"data-kt-autosize="true"></textarea>
                                                        <label
                                                            for="other_description_en_inp">{{ __('Enter description in English') }}</label>
                                                    </div>
                                                    <p class="text-danger invalid-feedback" id="other_description_en"></p>
                                                    <!-- end   :: Column -->
    
                                                </div>
                                                </div>                                                       
    
                                                    <!-- end :: Row -->
    

                                            <div class="separator separator-dashed my-4"></div>

                                            <!-- begin :: Row -->
                                            <div class="row">

                                                <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="car style" name="car_body"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'hatchback',
                                                                'value' => 'hatchback',
                                                                'id' => 'car_style_1',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'sedan',
                                                                'value' => 'sedan',
                                                                'id' => 'car_style_2',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => '4x4',
                                                                'value' => 'four-wheel-drive',
                                                                'id' => 'car_style_3',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'family',
                                                                'value' => 'family',
                                                                'id' => 'car_style_4',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'commercial',
                                                                'value' => 'commercial',
                                                                'id' => 'car_style_5',
                                                                'checked' => false,
                                                            ],
                                                        ]" />


                                                </div>
                                                <!-- end   :: Column -->

                                            </div>
                                            <!-- end   :: Row -->
                                            <div class="separator separator-dashed my-4"></div>

                                            <!-- begin :: Row -->
                                            <div class="row">

                                                <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="Publish car" name="publish"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'Yes',
                                                                'value' => '1',
                                                                'id' => 'publish_yes',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'No',
                                                                'value' => '0',
                                                                'id' => 'publish_no',
                                                                'checked' => false,
                                                            ],
                                                        ]" />

                                                </div>
                                                <!-- end   :: Column -->


                                                  
                                                </div>
                                  
                                            </div>
                                            <!-- end   :: Row -->


                                            <div class="separator separator-dashed my-4"></div>


                                            <!-- begin :: Row -->
                                            <div class="row">

                                                <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="Car condition" name="is_new"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'New',
                                                                'value' => '1',
                                                                'id' => 'is_new_used_radio_1',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'Used',
                                                                'value' => '0',
                                                                'id' => 'is_new_used_radio_2',

                                                                'checked' => false,
                                                            ],
                                                        ]" />



                                                </div>
                                                <div class="row d-flex align-items-center" style="display: none !important"
                                                    id="kilometers-container">
                                                    <div class="col-4">
                                                        <label class="col-form-label fs-5 fw-bold"><i
                                                                class="bi bi-dash-lg fs-8 mx-3"></i>{{ __('Number of kilometers') }}</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-floating">
                                                            <input class="form-control" type="number" min="1"
                                                                id="kilometers_inp" name="kilometers" placeholder="example">
                                                            <label
                                                                for="kilometers_inp">{{ __('Enter the kilometers') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-danger m-0 invalid-feedback" id="kilometers"></p>
                                                    </div>

                                                </div>
                                                <!-- end   :: Column -->


                                            </div>
                                            <!-- end   :: Row -->


                                            <div class="separator separator-dashed my-4"></div>

                                          
                                            <div class="separator separator-dashed my-4"></div>

                                            <!-- end   :: Row -->
                                            <div class="row">

                                                <!-- begin :: Column -->
                                                <div class="col-md-12 fv-row">

                                                    <x-dashboard.radio-btn title="gear shifter" name="gear_shifter"
                                                        :radio-btns="[
                                                            [
                                                                'label' => 'manual',
                                                                'value' => 'manual',
                                                                'id' => 'gear_shifter_manual',
                                                                'checked' => false,
                                                            ],
                                                            [
                                                                'label' => 'automatic',
                                                                'value' => 'automatic',
                                                                'id' => 'gear_shifter_automatic',
                                                                'checked' => false,
                                                            ],
                                                        ]" />

                                                </div>
                                                <!-- end   :: Column -->

                                            </div>
                                            <!-- end   :: Row -->     
                                            <!-- begin :: Row -->
                                                       
                                    <!-- begin :: Wizard Step 2 -->
                                    <div class="p-8" >
                                           <!-- begin  :: Row -->
                                           <div class="row mt-5">
                                            <hr>
                                            <div class="mt-5 mb-5">{{__('Images & Colors')}}</div>
                                        </div>
                                        <!-- end    :: Row -->
                                        <!-- begin :: Row -->
                                        <div class="row mb-10">

                                            <!-- begin :: Column -->
                                            <div class="col-md-12 fv-row">

                                                <label class="fs-5 fw-bold mb-2">{{ __("Colors") }}</label>

                                                <select class="form-select" data-control="select2" id="colors-sp" multiple data-placeholder="{{ __("Choose the color") }}" data-background-color="#000" data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">

                                                    @foreach( $colors as $color)
                                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                    @endforeach

                                                </select>
                                                <p class="invalid-feedback" id="colors" ></p>


                                        </div>
                                        <!-- end   :: Row -->

                                        <!-- begin :: car color component -->
                                        <div id="car-colors">

                                        </div>
                                        <!-- end   :: car color component -->


                                    </div>
                                    <!-- end   :: Wizard Step 2 -->
                                            <!-- end   :: Row -->     


                                            <!-- begin  :: Row -->
                                            <div class="row mt-5">
                                                <hr>
                                                <div class="mt-5 mb-5">{{__('features and possibilities')}}</div>
                                            </div>

                                            <!-- end    :: Row -->

                                            
                                            <!--begin::Repeater-->
                                            <div id="kt_docs_repeater_features">
                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div  class="features-repeater" data-repeater-list="features">
                                                        <div data-repeater-item>
                                                            <div class="form-group row align-items-center">
                                                                <div class="col-md-10">  
                                                                  <div class="row align-items-center">

                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">{{__('type')}}</label>
                                                                            <select class="form-select select-type" id="features_0_type_inp" name=features[0][type] data-placeholder="Select an option">
                                                                                <option value="" selected disabled>{{__("Select Type")}}</option>
                                                                                <option value="1">{{__("possibility")}}</option>
                                                                                <option value="2">{{__("feature")}}</option>
                                                                            </select>
                                                                            <div class="text-danger m-0 invalid-feedback" id="features_0_type"></div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">{{ __('Select Options') }}</label>
                                                                            <select  id="features_0_id_inp" name=features[0][id] class="form-select select-options" data-placeholder="Select an option" required>
                                                                                <option value="" selected disabled>{{__("Select an option")}}</option>
                                                                                <!-- Options will be populated by AJAX -->
                                                                            </select>
                                                                            <div class="text-danger m-0 invalid-feedback" id="features_0_id"></div>
                                                                        </div>
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">{{__('Description in arabic')}}</label>

                                                                            <input type="text" class="form-control mb-2 mb-md-0" id="features_0_description_ar_inp" name="features[0][description_ar]" placeholder="{{__('Description in arabic')}}" required />

                                                                            <div class="text-danger m-0 invalid-feedback" id="features_0_description_ar"></div>
                                                                        </div>
                                                                    
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">{{__('Description in english')}}</label>
                                                                            <input type="text" class="form-control mb-2 mb-md-0" id="features_0_description_en_inp" name="features[0][description_en]" placeholder="{{__('Description in english')}}" />
                                                                            <div class="text-danger m-0 invalid-feedback" id="features_0_description_en"></div>
                                                                            
                                                                        </div>
                                                                    </div>   
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="text-center">
                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3" id="features_0_delete_btn">
                                                                            <i class="far fa-trash-alt"></i>{{__('Delete')}}
                                                                            
                                                                        </a>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Form group-->

                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                        <i class="fa fa-plus"></i>
                                                        {{__('Add')}}
                                                    </a>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->

                                        </div>



                                        <div class="d-flex justify-content-between border-top py-10 px-10">

                                            <div>
                                                <button type="button"
                                                    class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 step-btn"
                                                    id="next-btn" data-btn-type="next">

                                                    <span class="indicator-label">{{ __('Save') }}</span>

                                                    <!-- begin :: Indicator -->
                                                    <span class="indicator-progress">{{ __('Please wait ...') }}
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                    <!-- end   :: Indicator -->


                                                </button>

                                            </div>
                                        </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- end   :: Wizard Body -->


                {{-- if (id) {
                    id = id.replace(/_\d+_/, '_' + index + '_'); // Update the id format with underscores
                    $(this).attr('id', id);
                } --}}


                <!-- end   :: Wizard -->
            </div>

        </div>
        <!-- end   :: Card -->
    @endsection
    @push('scripts')

     <script>
    // JavaScript Code
    document.addEventListener("DOMContentLoaded", function () {
        // Select all radio buttons and the "otherInputs" container
        const radioButtons = document.querySelectorAll('input[name="price_field_status"]');
        const otherInputs = document.getElementById("otherInputs");

        // Add event listeners to all radio buttons
        radioButtons.forEach(radio => {
            radio.addEventListener("change", function () {
                if (this.id === "others" && this.checked) {
                    otherInputs.style.display = "flex"; // Show the input fields
                } else {
                    otherInputs.style.display = "none"; // Hide the input fields
                }
            });
        });
    });
</script>
    <script>
       
        $(document).ready(function() {
            $('div[data-repeater-item]:first input , select').on('change', function () {
               
                var element = $(this);
                // If the input/select has a value, it's valid
                if (element.val()) {
                    element.removeClass('is-invalid').addClass('is-valid');
                    element.siblings('.invalid-feedback').hide(); // Hide error message if any
                } else {
                    element.removeClass('is-valid').addClass('is-invalid');
                    element.siblings('.invalid-feedback').show(); // Show error message if any
                    
                }
            });
       
            $('#kt_docs_repeater_features').repeater({
            
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                $(this).slideDown();
                // console.log( this)
                updateRepeaterIndex();
                
            },
            hide: function(deleteElement) {
            $(this).slideUp(deleteElement, function() {
                $(this).remove(); 
                updateRepeaterIndex(); // Call this after an item is deleted to reindex correctly
            });
            }
        
        });
        document.getElementById('features_0_delete_btn').style.display = 'none'; // Hide delete button for the first item

        $(document).on('change', '.select-type', function() {
            var selectedType = $(this).val();
            var $currentOptionsSelect = $(this).closest('[data-repeater-item]').find('.select-options');

            // Make AJAX call to fetch options based on the selected type
            $.ajax({
                url: '/dashboard/features/get-options',
                type: 'GET',
                data: { type: selectedType },
                success: function(response) {
                    // Clear the second select (options select) before appending new options
                    $currentOptionsSelect.empty();
                    $currentOptionsSelect.append(`<option value="" selected disabled>${__('Select an option')}</option>`);
    
                    console.log(response.options.length);
                    if(response.options.length==0){
                        $currentOptionsSelect.append(`<option value="" selected disabled> ${__('No data')} </option>`);
                    }else{
            
                      //  Populate the second select with the response data
                        $.each(response.options, function(value, name) {
                            $currentOptionsSelect.append('<option value="' + value + '">' + name + '</option>');
    
                        });
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });

     // Function to update input names and IDs after adding a new feature
  
    function updateRepeaterIndex() {
        
        $('#kt_docs_repeater_features [data-repeater-item]').each(function (index) {
            $(this).find('input, select ,a').each(function () {
                var name = $(this).attr('name');
                var id = $(this).attr('id');
            
                        
                if (name) { 
                    name = name.replace(/\[\d+\]/, '[' + index + ']'); // Update the name index
                    
                    $(this).attr('name', name);
                }
                
            

                if (id) {
                    id = id.replace(/_\d+_/, '_' + index + '_'); // Update the id format with underscores
                    $(this).attr('id', id);
                }

            
            });

            // Handle invalid-feedback and label 'for' attributes
            $(this).find('.invalid-feedback').each(function () {
                var errorId = $(this).attr('id');
                if (errorId) {
                    errorId = errorId.replace(/_\d+/, '_' + index); // Update invalid-feedback id with underscore
                    $(this).attr('id', errorId);


                }


            });

            $(this).find('label').each(function () {
                var forAttr = $(this).attr('for');
                if (forAttr) {
                    forAttr = forAttr.replace(/_\d+_/, '_' + index + '_');
                    $(this).attr('for', forAttr);
                }
            });
        });
    
        $('input, select').on('change', function () {
            var element = $(this);

            // If the input/select has a value, it's valid
            if (element.val()) {
                element.removeClass('is-invalid').addClass('is-valid');
                element.siblings('.invalid-feedback').hide(); // Hide error message if any
            } else {
                element.removeClass('is-valid').addClass('is-invalid');
                element.siblings('.invalid-feedback').show(); // Show error message if any
            }
        });
    }





    // Brand to Model dropdown change
    $('#brand-sp').on('change', function() {
        var brandId = $(this).val();
        $('#model-sp').empty().append('<option value="" selected></option>');
        if (brandId) {
            $.ajax({
                url: '/dashboard/get-models/' + brandId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#model-sp').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Model to Category dropdown change
    $('#model-sp').on('change', function() {
        var modelId = $(this).val();
        $('#category-sp').empty().append('<option value="" selected></option>');
        if (modelId) {
            $.ajax({
                url: '/dashboard/get-categories/' + modelId,
                type: 'GET',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#category-sp').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // TinyMCE initialization
    initTinyMc();

    // Kilometers input toggle based on radio selection
    $('#is_new_used_radio_1, #is_new_used_radio_2').change(function() {
        if ($(this).val() == 1) {
            $('#kilometers-container').hide();
            $('#kilometers_inp').val("");
        } else {
            $('#kilometers-container').show();
        }
    });

    
});

    </script>
        <script>
         
               let colors = @json($colors);
       </script>


    <!-- Additional Scripts -->
    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script src="{{ asset('js/dashboard/forms/cars/create.js') }}"></script>
    <script src="{{ asset('js/dashboard/components/wizard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>


@endpush

