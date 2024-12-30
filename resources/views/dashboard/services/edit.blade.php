@extends('partials.dashboard.master')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')

    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.services.index') }}"
                    class="text-muted text-hover-primary">{{ __("Services") }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __("Edit service") }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <div class="card">
        <!-- begin :: Card body -->
        <div class="card-body p-0">
            <!-- begin :: Form -->
            <form action="{{ route('dashboard.services.update',$service->id) }}" class="form" method="post" id="submitted-form" data-redirection-url="{{ route('dashboard.services.index') }}">
            @csrf
            @method("PUT")

            <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __("Edit service") . ' : ' . $service->name }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-center">

                            <div class="d-flex flex-column">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __("Image") }}</label>
                                <x-dashboard.upload-image-inp name="image" :image="$service->image" directory="Services" placeholder="default.jpg" type="editable" ></x-dashboard.upload-image-inp>
                                <p class="invalid-feedback" id="image" ></p>
                                <!-- end   :: Upload image component -->
                            </div>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __("Name in arabic") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_ar_inp" name="name_ar" value="{{ $service['name_ar'] }}" placeholder="example"/>
                                <label for="name_ar_inp">{{ __("Enter the name in arabic") }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_ar" ></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __("Name in english") }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name_en_inp" name="name_en" value="{{ $service['name_en'] }}" placeholder="example"/>
                                <label for="name_en_inp">{{ __("Enter the name in english") }}</label>
                            </div>
                            <p class="invalid-feedback" id="name_en" ></p>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __("Description in arabic") }}</label>

                            <div class="form-floating">
                                <textarea  class="form-control" id="description_ar_inp" name="description_ar" placeholder="example">
                                    {{ $service['description_ar'] }}
                                </textarea>
                                <label for="description_ar_inp">{{ __("Enter the description in arabic") }}</label>
                            </div>

                            <p class="invalid-feedback" id="description_ar" ></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                           
                            <label class="fs-5 fw-bold mb-2">{{ __("Description in english") }}</label>
                            <div class="form-floating">
                                <textarea  class="form-control" id="description_en_inp" name="description_en" placeholder="example">
                                    {{ $service['description_en'] }}
                                </textarea>
                                <label for="description_en_inp">{{ __("Enter the description in english") }}</label>
                            </div>

                            <p class="invalid-feedback" id="description_en" ></p>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __("Price") }}</label>
                            <div class="form-floating">
                                <input type="number" min="1" class="form-control" id="price_inp" name="price" value="{{ $service['price'] }}" placeholder="example"/>
                                <label for="price_inp">{{ __("Enter the price") }}</label>
                            </div>
                            <p class="invalid-feedback" id="price" ></p>


                        </div>
                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                                <label class="fs-5 fw-bold">{{ __("Discount price") }}</label>
                                <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox" id="discount-price-switch"  @if ( $service['discount_price'] ) checked @endif />
                                <label class="form-check-label" for="flexSwitchChecked"></label>
                            </div>

                            <div class="form-floating">
                                <input type="number" min="1" class="form-control" id="discount_price_inp" name="discount_price" value="{{ $service['discount_price'] }}" @if ( ! $service['discount_price'] ) disabled @endif placeholder="example"/>
                                <label for="discount_price_inp">{{ __("Enter the discount price") }}</label>
                            </div>
                            <p class="invalid-feedback" id="discount_price" ></p>


                        </div>
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->
                    <!-- begin  :: Row -->
                    <div class="row mt-5">
                        <hr>
                        <div class="mt-5 mb-5">{{__('features and possibilities')}}</div>
                    </div>
                    <!-- end    :: Row -->
                    <!--begin::Repeater-->
                    <div id="kt_docs_repeater_basic">
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div data-repeater-list="features">
                            
                                @forelse ($service->features as $feature)
                                    <div data-repeater-item>
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-10">  
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('Type') }}</label>
                                                        <select class="form-select select-type" id="features_{{$loop->index}}_type_inp"name="features[{{ $loop->index }}][type]" data-placeholder="Select an option">
                                                            <option value="1" {{ $feature->type == 1 ? 'selected' : '' }}>{{ __("possibility") }}</option>
                                                            <option value="2" {{ $feature->type == 2 ? 'selected' : '' }}>{{ __("feature") }}</option>
                                                        </select>
                                                        <div class="text-danger m-0 invalid-feedback"id="features_{{$loop->index}}_type"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('Select Options') }}</label>
                                                        <select id="features_{{$loop->index}}_id_inp" name="features[{{ $loop->index }}][id]" class="form-select select-options" data-selected-id="{{ $feature->id }}">
                                                            <option value="" selected disabled>{{ __("Select an option") }}</option>
                                                            <!-- Populated via JS -->
                                                        </select>
                                                        <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_id"></div>
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('Description in arabic') }}</label>
                                                        <input type="text" id="features_{{$loop->index}}_description_ar_inp" class="form-control" name="features[{{ $loop->index }}][description_ar]" value="{{ $feature->pivot->description_ar }}" placeholder="{{ __('Description in Arabic') }}" required />
                                                        <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_description_ar"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                    <label class="form-label">{{ __('Description in english') }}</label>
                                                    <input type="text" id="features_{{$loop->index}}_description_en_inp" class="form-control" name="features[{{ $loop->index }}][description_en]" value="{{ $feature->pivot->description_en }}" placeholder="{{ __('Description in English') }}" />
                                                    <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_description_en"></div>
                                                    </div>
                                                </div>    
                                            </div>    
                                            <div class="col-md-2">
                                                <div class="text-center">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="far fa-trash-alt"></i>{{__('Delete')}}
                                                        
                                                    </a>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                
                                    <div data-repeater-item>
                                        <div class="form-group row align-items-center">
                                            <div class="col-md-10">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6 mb-3 ">
                                                        <label class="form-label">{{ __('Type') }}</label>
                                                        <select id="features_0_type_inp" class="form-select select-type" name="features[0][type]" data-placeholder="Select an option">
                                                            <option value="1">{{ __("possibility") }}</option>
                                                            <option value="2">{{ __("feature") }}</option>
                                                        </select>
                                                        <div class="text-danger m-0 invalid-feedback" id="features_0_type"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3 ">
                                                        <label class="form-label">{{ __('Select Options') }}</label>
                                                        <select name="features[0][id]" id="features_0_id_inp" class="form-select select-options"id="features_0_id_inp">
                                                            <option value="" selected disabled>{{ __("Select an option") }}</option>
                                                            <!-- Populated via JS -->
                                                        </select>
                                                        <div class="text-danger m-0 invalid-feedback" id="features_0_id"></div>
                                                        
                                                    </div>
                                                    <div class="col-md-6 mb-3 ">
                                                        <label class="form-label">{{ __('Description in arabic') }}</label>
                                                        <input type="text" id="features_0_description_ar_inp" class="form-control" name="features[0][description_ar]"  placeholder="{{ __('Description in arabic') }}"  />
                                                        <div class="text-danger m-0 invalid-feedback" id="features_0_description_ar"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3 ">

                                                        <label class="form-label">{{ __('Description in english') }}</label>
                                                        <input type="text" id="features_0_description_en_inp" class="form-control" name="features[0][description_en]" placeholder="{{ __('Description in english') }}" />
                                                        <div class="text-danger m-0 invalid-feedback"id="features_0_description_en" ></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-center">
                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3">
                                                        <i class="far fa-trash-alt"></i>{{__('Delete')}}
                                                        
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!--end::Form group-->
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                <i class="fa fa-plus "></i> {{__('Add')}}
                            </a>
                        </div>
                    </div>
                    <!--end::Repeater-->



                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __("Save") }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __("Please wait ...") }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!-- end   :: Indicator -->

                    </button>
                    <!-- end   :: Submit btn -->

                </div>
                <!-- end   :: Form footer -->
            </form>
            <!-- end   :: Form -->
        </div>
        <!-- end   :: Card body -->
    </div>

@endsection
@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

    <script>

        let discountInp = $("#discount_price_inp");

        $(document).ready( () => {

            //initSummerNotes();

            $('#kt_docs_repeater_basic').repeater({
        initEmpty: false,
        show: function() {
            $(this).slideDown();
            updateRepeaterIndex();
            bindSelectTypeChangeEvent($(this)); // Bind event for new items
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement, function() {
                $(this).remove(); 
                updateRepeaterIndex();
            });
        }
     });

     populateExistingOptions();

     function updateRepeaterIndex() {
        
        $('[data-repeater-item]').each(function (index) {
            $(this).find('input, select').each(function () {
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

     function populateExistingOptions() {
        $('.select-type').each(function() {
            bindSelectTypeChangeEvent($(this).closest('[data-repeater-item]'));
        });
     }

     function bindSelectTypeChangeEvent($repeaterItem) {
        var $typeSelect = $repeaterItem.find('.select-type');
        var $optionSelect = $repeaterItem.find('.select-options');
        var selectedOptionId = $optionSelect.data('selected-id');

        // Make AJAX call to fetch options based on the selected type
        $.ajax({
            url: '/dashboard/features/get-options',
            type: 'GET',
            data: { type: $typeSelect.val() },
            success: function(response) {
                $optionSelect.empty();
                $optionSelect.append(`<option value="" disabled>{{__("Select an option")}}</option>`);
                $.each(response.options, function(feature_id, name) {
                var selectedAttribute = feature_id == selectedOptionId ? 'selected' : '';
                console.log(selectedAttribute)
                $optionSelect.append('<option value="' + feature_id + '" ' + selectedAttribute + '>' + name + '</option>');
                });
                
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });

        // On type change, update options dynamically
        $typeSelect.on('change', function() {
            $.ajax({
                url: '/dashboard/features/get-options',
                type: 'GET',
                data: { type: $(this).val() },
                success: function(response) {
                    $optionSelect.empty();
                    $optionSelect.append('<option value="" disabled>{{__("Select an option")}}</option>');
                    $.each(response.options, function(feature_id, name) {
                        $optionSelect.append('<option value="' + feature_id + '">' + name + '</option>');
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
     }


            $("#discount-price-switch").change( function () {
                discountInp.prop('disabled' , ! $(this).prop('checked'))
            });

        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>

@endpush
