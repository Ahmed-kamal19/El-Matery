@extends('partials.dashboard.master')
@section('content')

<!-- begin :: Subheader -->
<div class="toolbar">

    <div class="container-fluid d-flex flex-stack">

        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

            <!-- begin :: Title -->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a href="{{ route('dashboard.features.index') }}" class="text-muted text-hover-primary">{{ __("features and possibilities") }}</a></h1>
            <!-- end   :: Title -->

            <!-- begin :: Separator -->
            <span class="h-20px border-gray-300 border-start mx-4"></span>
            <!-- end   :: Separator -->

            <!-- begin :: Breadcrumb -->
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <!-- begin :: Item -->
                <li class="breadcrumb-item text-muted">
                    {{ __("Add new feature or posibility") }}
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
        <form action="{{ route('dashboard.features.store') }}"  class="form" method="post" id="submitted-form" data-redirection-url="{{ route('dashboard.features.index') }}"  enctype="multipart/form-data">
            @csrf
            <!-- begin :: Card header -->
            <div class="card-header d-flex align-items-center">
                <h3 class="fw-bolder text-dark">{{ __("Add new feature or posibility") }}</h3>
            </div>
            <!-- end   :: Card header -->

            <!-- begin :: Inputs wrapper -->
            <div class="inputs-wrapper">

                
                    <!-- begin :: Row -->
                    <div class="row mb-20">

                        <!-- begin :: Column -->
                        <div class="col-md-12 fv-row d-flex justify-content-evenly">

                            <div class="d-flex flex-column align-items-center">
                                <!-- begin :: Upload image component -->
                                <label class="text-center fw-bold mb-4">{{ __('Icon') }}</label>
                                <div>
                                    <x-dashboard.upload-image-inp name="icon" :image="null" :directory="null"
                                        placeholder="default.jpg" type="editable"></x-dashboard.upload-image-inp>
                                </div>
                                <p class="invalid-feedback" id="icon"></p>
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
                            <input type="text" class="form-control" id="title_ar_inp" name="title_ar" placeholder="example" />
                            <label for="title_ar_inp">{{ __("Enter the name in arabic") }}</label>
                        </div>
                        <p class="invalid-feedback" id="title_ar"></p>


                    </div>
                    <!-- end   :: Column -->

                    <!-- begin :: Column -->
                    <div class="col-md-6 fv-row">

                        <label class="fs-5 fw-bold mb-2">{{ __("Name in english") }}</label>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="title_en_inp" name="title_en" placeholder="example" />
                            <label for="title_en_inp">{{ __("Enter the name in english") }}</label>
                        </div>
                        <p class="invalid-feedback" id="title_en"></p>



                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->
                <!-- begin :: Row -->
                <div class="row mb-10">

                    <!-- begin :: Column -->
                      <div class="col-md-6 fv-row">

                        <label class="fs-5 fw-bold mb-2">{{ __("type") }}</label>
                        <div class="form-floating">
                            <select  class="form-control" id="type_inp" name="type" >
                                <option value="" disabled selected>{{ __('select_type') }}</option>
                                <option value="1">{{__('posibility')}}</option>
                                <option value="2">{{__('feature')}}</option>
                            </select>
                        </div>
                        <p class="invalid-feedback" id="type"></p>
                    </div>
                    <!-- end   :: Column -->

                </div>
                <!-- end   :: Row -->

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
