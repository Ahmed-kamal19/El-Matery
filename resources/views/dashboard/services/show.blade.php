@extends('partials.dashboard.master')
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
                        {{ __("service data") }}
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

            <!-- begin :: Card header -->
            <div class="card-header d-flex align-items-center">
                <h3 class="fw-bolder text-dark">{{ __("service data") . ' : ' . $service->name }}</h3>
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
                            <x-dashboard.upload-image-inp name="image" :image="$service->image" directory="Services" placeholder="default.jpg" type="show" ></x-dashboard.upload-image-inp>
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
                        <input type="text" class="form-control"  value="{{ $service['name_ar'] }}" readonly />

                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-5 fw-bold mb-2">{{ __("Name in english") }}</label>
                        <input type="text" class="form-control"  value="{{ $service['name_en'] }}"  readonly />


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
                        <textarea  class="form-control" id="description_ar_inp" name="description_ar" placeholder="example" readonly>
                            {{ $service['description_ar'] }}
                        </textarea>
                      
                    </div>

                    <p class="invalid-feedback" id="description_ar" ></p>


                </div>
                <!-- end   :: Column -->

                <!-- begin :: Column -->
                <div class="col-md-6 fv-row">
                   
                    <label class="fs-5 fw-bold mb-2">{{ __("Description in english") }}</label>
                    <div class="form-floating">
                        <textarea  class="form-control" id="description_en_inp" name="description_en" placeholder="example" readonly>
                            {{ $service['description_en'] }}
                        </textarea>
                       
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
                        <input type="number" min="1" class="form-control" readonly value="{{ $service['price'] }}" />


                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <div class="form-check form-switch form-check-custom form-check-solid mb-2">
                            <label class="fs-5 fw-bold">{{ __("Discount price") }}</label>
                            <input class="form-check-input mx-2" style="height: 18px;width:36px;" type="checkbox" disabled @if ( $service['discount_price'] ) checked @endif />
                            <label class="form-check-label" for="flexSwitchChecked"></label>
                        </div>

                        <input type="number" min="1" class="form-control" id="discount_price_inp" name="discount_price" value="{{ $service['discount_price'] }}" readonly />


                    </div>
                    <!-- end   :: Column -->

                </div>
             
             </div>
               <!-- end   :: Row -->
         
               @if(!$service->features->isEmpty())
               <!-- begin  :: Row -->
                   <div class="row mt-5">
                       <hr>
                       <div class="mt-5 mb-5">{{__('features and possibilities')}}</div>
                   </div>
               <!-- end    :: Row -->    
                <div id="kt_docs_repeater_basic">
                <!--begin::Form group-->
                <div class="form-group">
                    <div data-repeater-list="features">
                    
                        @forelse ($service->features as $feature)
                            <div data-repeater-item>
                                <div class="form-group row align-items-center"> 
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('Type') }}</label>
                                                <select class="form-select select-type" id="features_{{$loop->index}}_type_inp"name="features[{{ $loop->index }}][type]" data-placeholder="Select an option" disabled>
                                                    <option value="1" {{ $feature->type == 1 ? 'selected' : '' }}>{{ __("possibility") }}</option>
                                                    <option value="2" {{ $feature->type == 2 ? 'selected' : '' }}>{{ __("feature") }}</option>
                                                </select>
                                                <div class="text-danger m-0 invalid-feedback"id="features_{{$loop->index}}_type"></div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('Select Options') }}</label>
                                                <select id="features_{{$loop->index}}_id_inp" name="features[{{ $loop->index }}][id]" class="form-select select-options" data-selected-id="{{ $feature->id }}" disabled>
                                                    <option value="" selected disabled>{{ __("Select an option") }}</option>
                                                    <!-- Populated via JS -->
                                                </select>
                                                <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_id"></div>
                                            </div>
                                        
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('Description in arabic') }}</label>
                                                <input type="text" id="features_{{$loop->index}}_description_ar_inp" class="form-control" name="features[{{ $loop->index }}][description_ar]" value="{{ $feature->pivot->description_ar }}" placeholder="{{ __('Description in Arabic') }}" readonly />
                                                <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_description_ar"></div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                            <label class="form-label">{{ __('Description in english') }}</label>
                                            <input type="text" id="features_{{$loop->index}}_description_en_inp" class="form-control" name="features[{{ $loop->index }}][description_en]" value="{{ $feature->pivot->description_en }}" placeholder="{{ __('Description in English') }}" readonly/>
                                            <div class="text-danger m-0 invalid-feedback" id="features_{{$loop->index}}_description_en"></div>
                                            </div>
                                </div>
                            </div>
                        @empty
                        @endforelse    
                    </div>
                </div>
            </div>    
            @endif
            


            </div>
            <!-- end   :: Inputs wrapper -->


            <!-- begin :: Form footer -->
            <div class="form-footer">

                <!-- begin :: Submit btn -->
                <a href="{{ route('dashboard.services.index') }}" class="btn btn-primary" >

                    <span class="indicator-label">{{ __("Back") }}</span>

                </a>
                <!-- end   :: Submit btn -->

            </div>
            <!-- end   :: Form footer -->
            <!-- end   :: Form -->
        </div>
        <!-- end   :: Card body -->
    </div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>


<script>
     $(document).ready(function() {
       
       populateExistingOptions();
       updateRepeaterIndex()
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
      
       
       }
  
       function populateExistingOptions() {
          $('.select-type').each(function() {
              bindSelectTypeChangeEvent($(this).closest('[data-repeater-item]'));
          });
       }
  
       function bindSelectTypeChangeEvent($repeaterItem) {
          var $typeSelect = $repeaterItem.find('.select-type');
          var $optionSelect = $repeaterItem.find('.select-options');
          console.log("Type selected: ", $typeSelect.val()); // Debugging

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
                      $optionSelect.append('<option value="' + feature_id + '" ' + selectedAttribute + '>' + name + '</option>');
                  });
              },
              error: function(error) {
                  console.log('Error:', error);
              }
          });
  
       }
          });
     
</script>

