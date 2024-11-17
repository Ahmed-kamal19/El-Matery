@extends('partials.dashboard.master')
@section('content')
    <!-- begin :: Subheader -->
    <div class="toolbar">

        <div class="container-fluid d-flex flex-stack">

            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                <!-- begin :: Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><a
                        href="{{ route('dashboard.news.index') }}"
                        class="text-muted text-hover-primary">{{ __('features') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new feature') }}
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
            <form action="{{ route('dashboard.feature.store') }}" class="form" method="post" id="submitted-form"
                data-success-message="{{ __('features added successfully') }}"
                data-redirection-url="{{ route('dashboard.feature.index') }}">
                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">

                    <div class="card-title">
                        <h3 class="fw-bolder text-dark">{{ __('Add new feature') }}</h3>
                    </div>

                    

                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">


                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                      
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->


                    <!-- begin :: Row -->
                    <div class="row mb-8">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Enter the feature title_ar') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="title_ar"
                                    placeholder="example" />
                                <label for="title_inp">{{ __('Enter the possibility title_ar ') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Enter the feature title_en') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="title_en"
                                    placeholder="example" />
                                <label for="title_inp">{{ __('Enter the possibility title_en ') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->



                        
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('favicon') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title_inp" name="icon"
                                    placeholder="example" />
                                <label for="title_inp">{{ __('favicon') }}</label>
                            </div>
                            <p class="invalid-feedback" id="favicon"></p>

                        </div>
                        <!-- end   :: Column -->

                      
                      
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                    <div class="row mb-10">

                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('feature description_ar') }}</label>
                            <textarea class="form-control" rows="4" name="description_ar" id="meta_tag_description_en_inp"
                                data-kt-autosize="true"></textarea>
                            <p class="text-danger invalid-feedback" id="description"></p>

                        </div>

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('feature description_en') }}</label>
                            <textarea class="form-control" rows="4" name="description_en" id="meta_tag_description_en_inp"
                                data-kt-autosize="true"></textarea>
                            <p class="text-danger invalid-feedback" id="description"></p>

                        </div>



                        <!-- end   :: Column -->

                        <!-- begin :: Column -->
                    
                        <!-- end   :: Column -->

                    </div>
                    <!-- end   :: Row -->


                </div>
                <!-- end   :: Inputs wrapper -->

                <!-- begin :: Form footer -->
                <div class="form-footer">

                    <!-- begin :: Submit btn -->
                    <button type="submit" class="btn btn-primary" id="submit-btn">

                        <span class="indicator-label">{{ __('Save') }}</span>

                        <!-- begin :: Indicator -->
                        <span class="indicator-progress">{{ __('Please wait ...') }}
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
    <script src="{{ asset('dashboard-assets/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script>
        $(document).ready(() => {

            initTinyMc();

            new Tagify(document.getElementById('tags_inp'), {
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            });

        });
    </script>
@endpush
