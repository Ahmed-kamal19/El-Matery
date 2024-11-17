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
                        class="text-muted text-hover-primary">{{ __('partners') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Add new partner') }}
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
            <form action="{{ route('dashboard.partners.store') }}" class="form" method="post" id="submitted-form"
                data-success-message="{{ __('Partner added successfully') }}"
                data-redirection-url="{{ route('dashboard.partners.index') }}"
                enctype="multipart/form-data">

                @csrf
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">

                    <div class="card-title">
                        <h3 class="fw-bolder text-dark">{{ __('Add new partner') }}</h3>
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
                       
                        <!-- end   :: Column -->

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('image') }}</label>
                            <div class="form-floating">
                                <input type="file" class="form-control" id="title_inp" name="image"
                                    placeholder="example" />
                                <label for="title_inp">{{ __('image ') }}</label>
                            </div>
                            <p class="invalid-feedback" id="title"></p>

                        </div>
                        <!-- end   :: Column -->



                        
                        <!-- begin :: Column -->
                      
                        <!-- end   :: Column -->

                      
                      
                    </div>
                    <!-- end   :: Row -->

                    <!-- begin :: Row -->
                     
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
