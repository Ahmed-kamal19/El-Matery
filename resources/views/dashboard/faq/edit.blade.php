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
                        href="{{ route('dashboard.faqs.index') }}"
                        class="text-muted text-hover-primary">{{ __('FAQs') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Edit a question') }}
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
            <form action="{{ route('dashboard.faqs.update', $faq->id) }}" class="form" method="post" id="submitted-form"
                data-redirection-url="{{ route('dashboard.faqs.index') }}">
                @csrf
                @method('PUT')
                <!-- begin :: Card header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="fw-bolder text-dark">{{ __('Edit question') . ' : ' . $faq->question }}</h3>
                </div>
                <!-- end   :: Card header -->

                <!-- begin :: Inputs wrapper -->
                <div class="inputs-wrapper">
                    <!-- begin :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Question Arabic') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="question_ar_inp" name="question_ar"
                                    value="{{ $faq->question_ar }}" placeholder="example" />
                                <label for="question_ar_inp">{{ __('Enter question Arabic') }}</label>
                            </div>
                            <p class="invalid-feedback" id="question_ar"></p>

                        </div>
                        <!-- end   :: Column -->
                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Question English') }}</label>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="question_en_inp" name="question_en"
                                    value="{{ $faq->question_en }}" placeholder="example" />
                                <label for="question_en_inp">{{ __('Enter question English') }}</label>
                            </div>
                            <p class="invalid-feedback" id="question_en"></p>

                        </div>
                        <!-- end   :: Column -->
                    </div>
                    <!-- end   :: Row -->
                    <div class="row mb-8">
                        <!-- begin :: Column -->
                        <div class="col-md-6 fv-row">
                            <label class="fs-5 fw-bold mb-2">{{ __('Answer Arabic') }}</label>
                            <div class="form-floating">
                                <textarea class="form-control" name="answer_ar" id="answer_ar_inp" data-kt-autosize="true">{{ $faq->answer_ar }}</textarea>
                                <label for="answer_ar_inp">{{ __('Enter answer Arabic') }}</label>
                            </div>
                            <p class="invalid-feedback" id="answer_ar"></p>

                        </div>
                        <!-- end   :: Column -->

                        <div class="col-md-6 fv-row">

                            <label class="fs-5 fw-bold mb-2">{{ __('Answer English') }}</label>
                            <div class="form-floating">
                                <textarea class="form-control" name="answer_en" id="answer_en_inp" data-kt-autosize="true">{{ $faq->answer_en }}</textarea>
                                <label for="answer_en_inp">{{ __('Enter answer English') }}</label>
                            </div>
                            <p class="invalid-feedback" id="answer_en"></p>

                        </div>
                        <!-- end   :: Column -->
                    </div>
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

            initTinyMc(true);

        });
    </script>
@endpush
