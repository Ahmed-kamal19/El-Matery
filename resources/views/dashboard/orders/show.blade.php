
@extends('partials.dashboard.master')
@push('styles')
    <link href="{{ asset('dashboard-assets/css/wizard' . (isArabic() ? '.rtl' : '') . '.css') }}" rel="stylesheet"
        type="text/css" />
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
                       href="{{ route('dashboard.orders.index') }}"
                        class="text-muted text-hover-primary">{{ __('Orders') }}</a></h1>
                <!-- end   :: Title -->

                <!-- begin :: Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <!-- end   :: Separator -->

                <!-- begin :: Breadcrumb -->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <!-- begin :: Item -->
                    <li class="breadcrumb-item text-muted">
                        {{ __('Order data') }}
                    </li>
                    <!-- end   :: Item -->
                </ul>
                <!-- end   :: Breadcrumb -->

            </div>

        </div>

    </div>
    <!-- end   :: Subheader -->

    <!--begin::Order details page-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-lg-n2 me-auto">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_ecommerce_sales_order_summary">{{ __('Order Summary') }}</a>
                </li>
                
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_ecommerce_sales_order_history">{{ __('Order History') }}</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->


            <div class="w-200px">

                <!--begin::Select2-->
                @if($order['status_id'] == '9' ||$order['status_id'] == '11' )
                 <select class="form-select" data-control="select2" data-hide-search="false" disabled name="status" id="order-status-sp"
                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" data-placeholder="{{ __('Status') }}">
                    @foreach (settings()->getOrdersStatus() ?? [] as $status)
                        <option value="{{ $status['id'] . '_' . $status['name_en'] }}"
                            {{ $status['id'] == $order['status_id'] ? 'selected' : '' }}>
                            {{ $status['name_' . getLocale()] }}</option>
                    @endforeach
                </select>

                @else
                <select class="form-select" data-control="select2" data-hide-search="false"   name="status" id="order-status-sp"
                data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}" data-placeholder="{{ __('Status') }}">
                @foreach (settings()->getOrdersStatus() ?? [] as $status)
                    <option value="{{ $status['id'] . '_' . $status['name_en'] }}"
                        {{ $status['id'] == $order['status_id'] ? 'selected' : '' }}>
                        {{ $status['name_' . getLocale()] }}</option>
                @endforeach
            </select>
                @endif
                <!--end::Select2-->
            </div>
            @can('show_orders')
            <div class="w-200px">
                <select class="form-select" data-control="select2" data-hide-search="false" name="employee_id"
                    id="employee-sp"  
                    data-dir="{{ isArabic() ? 'rtl' : 'ltr' }}">
                    <option value="" disabled>{{ __('Assign the employee') }}</option>
                    @foreach ($employees as $employeedat)
                        @if($employeedat)
                            <option value="{{ $employeedat->id }}" 
                                {{  $userAssign->name == $employeedat->name ? 'selected' : '' }}>
                                {{ $employeedat->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <p class="invalid-feedback" id="employee_id"></p>
            </div>
        @endcan
        
            {{-- @endif --}}


        </div>
        <!--begin::Order summary-->
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <!--begin::Order details-->

            <div class="card card-flush  flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('Order Details') }} ( #{{ $order['id'] }} )</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                       
                             
                                @if ($order->city_id)
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('City') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->city->name }}
                                        </td>
                                    </tr>
                                @endif
                              
                                <!--begin::Date-->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-calendar mx-2"></i>
                                            </span> {{ __('Date') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ date('Y-m-d', strtotime($order['created_at'])) }}
                                    </td>
                                </tr>
                                <!--end::Date-->
                                <!--begin::Time-->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-clock mx-2"></i>
                                            </span> {{ __('Time') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">{{ date('H:i a', strtotime($order['created_at'])) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-clock mx-2"></i>
                                            </span> {{ __('Payment Type') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                    {{ __(ucfirst($order['orderDetailsCar']['payment_type'] ?? '')) }}

                                    </td>
                                </tr>
                           
                                



                               




                         
                                
                             
                                
                             
                                
                                
                                <!--end::Time-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Order details-->
            <!--begin::Customer details-->
            <div class="card card-flush  flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header d-flex justify-content-between align-items-between">
                    <div class="card-title ">
                        <h2 style="font-weight:bold; ">{{ __('Customer Details') }}</h2>

                    </div>

                    @if($order->orderDetailsCar)
                    @if ($order->orderDetailsCar->type == 'individual')
                        <div class="ps-4">
                            <a href="https://wa.me/{{ $order['phone'] }}?text={{ urlencode(__('السلام عليكم. موقع كود كار للسيارات يرحب بكم ويسعدنا التواصل معك بخصوص طلبك رقم ' . $order['id'] . ' لسيارة: ' . $order['car_name'] . '')) }}"
                                target="_blank" title="Chat on WhatsApp" class="whatsapp-icon">
                                <img src="{{ asset('dashboard-assets/media/svg/social-logos/whatsapp.svg') }}"
                                    alt="WhatsApp Logo"
                                    style="width:50px; height: 50px; margin-left: 23px; margin-right: 23px;">
                            </a>
                        </div>
                    @else
                        @if ($order['orderDetailsCar']['cars'])
                            @php
                                $carCount = 0;
                            @endphp
                            @foreach (json_decode($order['orderDetailsCar']['cars'], true) as $car)
                                @if (isset($car))
                                    {{-- Here you can put any code related to displaying individual cars --}}
                                    @php
                                        $carCount += $car['count'];
                                    @endphp
                                @endif  

                            @endforeach
                           
                            </div>
                        @else
                         @endif
                    @endif
                    @endif




                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                                <!--begin::Customer name-->
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-user mx-2"></i>
                                            </span>
                                            {{ __('Customer') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin::Name-->
                                            @if ($order->orderDetailsCar->type == 'individual')
                                            {{ $order->name }}
                                            @else
                                            {{ $order->orderDetailsCar->organization_name }}
                                            @endif
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                @if($order->orderDetailsCar->type == 'organization')
                                <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-user mx-2"></i>
                                                </span>
                                                {{ __('Organization Age') }}
                                            </div>
                                        </td>
                                        <td class="text-end fw-boldest" colspan="4">
                                                        {{ $order['orderDetailsCar']['organization_age']}}
                                                    </td>                                        </td>
                                    </tr>
                                                      
                                @endif
                                <!--end::Customer name-->
                                <!--begin::Date-->
                                @if ($order['phone'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Svg Icon-->
                                                <span class="svg-icon svg-icon-2 me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M5 20H19V21C19 21.6 18.6 22 18 22H6C5.4 22 5 21.6 5 21V20ZM19 3C19 2.4 18.6 2 18 2H6C5.4 2 5 2.4 5 3V4H19V3Z"
                                                            fill="black" />
                                                        <path opacity="0.3" d="M19 4H5V20H19V4Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                {{ __('Phone') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->phone }}</td>
                                    </tr>
                                @endif
                                
                                @if ($order['identity_no'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-user mx-2"></i>
                                                </span>
                                                {{ __('Identity no') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ __($order['identity_no']) }}
                                        </td>
                                    </tr>
                                @endif
                                @if($order->orderDetailsCar->payment_type == 'finance' && $order->orderDetailsCar->type == 'individual')

                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-clock mx-2"></i>
                                            </span> {{ __('Salary') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        {{ $order['orderDetailsCar']['salary'] . ' ' . currency() }}
                                        
                                    </td>
                                </tr>
                                @endif
                                @if($order->orderDetailsCar->type == 'individual')

                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-clock mx-2"></i>
                                            </span> {{ __('Email') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
                                        {{ $order->email }}
                                        
                                    </td>
                                </tr>

                                @endif



                                 @if($order->orderDetailsCar->payment_type == 'finance' && $order->orderDetailsCar->type == 'individual')

                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <span>
                                                <i class="fa fa-clock mx-2"></i>
                                            </span> {{ __('Work type') }}
                                        </div>
                                    </td>
                                    <td class="fw-bolder text-end">
  
                                     {{ $order->orderDetailsCar->work }}

 
                                     </td>
                                </tr>
                                @endif

                                @if ($order->orderDetailsCar->bank)

                                     <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('Bank') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            
                                        {{ $order->orderDetailsCar->bank['name_' . getLocale()] }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($order->orderDetailsCar['commitments'])

                                     <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('Commitments') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">
                                            
                                             {{ $order->orderDetailsCar->commitments }}

                                        </td>
                                    </tr>
                                @endif
 





                                @if ($order->orderDetailsCar['organization_name'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('Organization Name') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->orderDetailsCar['organization_name']}}
                                        </td>
                                    </tr>
                                @endif

                                @if ($order->orderDetailsCar['organization_email'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('Organization Email') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->orderDetailsCar['organization_email']}}
                                        </td>
                                    </tr>
                                @endif
                                @if ($order->orderDetailsCar['organization_location'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('location') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->orderDetailsCar['organization_location']}}
                                        </td>
                                    </tr>
                                @endif
                                @if ($order->orderDetailsCar['organization_activity'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('Organization Activity') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->orderDetailsCar['organization_activity']}}
                                        </td>
                                    </tr>
                                @endif
                                @if ($order->orderDetailsCar['organization_seo'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-map-marker mx-2"></i>
                                                </span>
                                                {{ __('The Chief Executive Officer (CEO)') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order->orderDetailsCar['organization_seo']}}
                                        </td>
                                    </tr>
                                @endif





                                @if ($order['birth_date'])
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <i class="fa fa-calendar mx-2"></i>
                                                </span>


                                                {{ __('Birth date') }}
                                            </div>
                                        </td>
                                        <td class="fw-bolder text-end">{{ $order['birth_date'] }}</td>
                                    </tr>
                                @endif
                                <!--end::Date-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Customer details-->
        </div>
        <!--end::Order summary-->
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                <!--begin::Orders-->

                                 <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Product List-->
                        <div class="card card-flush flex-row-fluid overflow-hidden">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('Order') }} #{{ $order['id'] . ' ' }} </h2>
                                </div>
                                <div class="card-title">
                                    <h2>{{ __('Order Type') . ' : ' }}
                                        {{ __(str_replace('_', ' ', $order->orderDetailsCar->type ?? null)) . ' '}} </h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>
                                                <td class="text-start fw-boldest" colspan="4">{{ __('Car name') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <!--be  gin::Title-->
                                                        <div class="ms-5">
                                                            <a href="{{route('dashboard.cars.show',$order->car->id)}}"
                                                                class="fw-boldest text-gray-600 text-hover-primary">{{ $order->car->name }}</a>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(settings()->getSettings('maintenance_mode') == 1 )
                                            @if($order->orderDetailsCar->type == 'organization')
                                            <tr>
                                                <td class="text-start fw-boldest" colspan="4">{{ __('price') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <!--be  gin::Title-->
                                                        <div class="ms-5">
                                                            <a href="#"
                                                                class="fw-boldest text-gray-600 text-hover-primary">
                                                                {{  $order->car->price_field_status!='show'?$order->car->price_field_status:$order->price}}

                                                            
                                                            </a>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>
                                            </tr>
                                            @else 
                                            <tr>
                                                <td class="text-start fw-boldest" colspan="4">{{ __('price') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <!--be  gin::Title-->
                                                        <div class="ms-5">
                                                            <a href="#"
                                                                class="fw-boldest text-gray-600 text-hover-primary">
                                                                {{  $order->car->price_field_status!='show'?$order->car->price_field_status:$order->price}}

                                                            
                                                            </a>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            @endif
                                            @if($order->orderDetailsCar->type == 'organization')

<tr>
                                                <td class="text-start fw-boldest" colspan="4">{{ __('Quantity') }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <!--be  gin::Title-->
                                                        <div class="ms-5">
                                                                <a href="#" class="fw-boldest text-gray-600 text-hover-primary">
                                                                    {{$order->quantity}}
                                                                </a>
                                                            

                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="exampleModalLabel">chassis</h5>
                                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <ul>
                                                                @foreach ($carStores as $carStore )
                                                                 <li> {{$carStore->chassis }}
                                                                </li>
                                                                 @endforeach
 
                                                              </ul>
                                                            </div>
                                                            <div class="modal-footer">


                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      
                                                      
                                                </td>
                                            </tr>


                                            <td class="text-start fw-boldest" colspan="4">{{ __('chassis') }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <!--be  gin::Title-->
                                                    <div class="ms-5">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            {{__('show Chassis')}}
                                                        </button>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
@endif


                                            @if($order->orderDetailsCar->driving_license)
                                            <tr>
                                                <td class="fw-boldest">{{ __('Driving License Status') }}</td>
                                                <td class="text-end fw-boldest" colspan="4">
                                                                                                                  {{ __(str_replace('_', ' ', $order['orderDetailsCar']['driving_license'])) }}
</td>
                                            </tr>
                                              
@endif



                                           
                                            
                                @if($order->orderDetailsCar->payment_type == 'finance' && $order->orderDetailsCar->type == 'individual' )
 
 <tr>
     <td class="fw-boldest">{{ __('Is there a mortgage loan') }}</td>
     <td class="text-end fw-boldest" colspan="4">
         {{ $order->orderDetailsCar->having_loan == 1? __('Yes'): __('No')}}</td>
 </tr>
 @endif


 @if($order->orderDetailsCar->payment_type == 'finance' && $order->orderDetailsCar->type == 'individual')
                                            <tr>
                                                <td class="fw-boldest">{{ __('The first installment') }}</td>
                                                <td class="text-end fw-boldest" colspan="4">
                                                {{ $order->orderDetailsCar->first_payment_value }}
                                                </tr>
 
@endif
@if($order->orderDetailsCar->payment_type == 'finance' && $order->orderDetailsCar->type == 'individual')

<tr>
                                                <td class="fw-boldest"> {{ __('The last installment') }}</td>
                                                <td class="text-end fw-boldest" colspan="4">

                                                {{ $order->orderDetailsCar->last_payment_value }}                                                </tr>

@endif
                          


                                        </tbody>
                                        <!--end::Table head-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Product List-->
                    </div>

                <!--end::Orders-->
                <!-- Assuming you are using Bootstrap that comes with Metronic -->
                @if ($order['identity_Card'] || $order['License_Card'] || $order['Hr_Letter_Image'] || $order['Insurance_Image'])
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div style="text-align: center; margin-bottom:30px">
                                    <h5 class="card-title">{{ __('Download Documents') }}</h5>
                                    <p class="card-text">
                                        {{ __('Click on the buttons below to download your documents') }}.</p>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    @if ($order['identity_Card'])
                                        <a href="{{ route('dashboard.files.download', $order['identity_Card']) }}"
                                            class="btn btn-success me-md-2" target="_blank">
                                            <i class="bi bi-file-earmark-arrow-down"></i>
                                            {{ __('Download Identity Card') }}
                                        </a>
                                    @endif
                                    @if ($order['License_Card'])
                                        <a href="{{ route('dashboard.files.download', $order['License_Card']) }}"
                                            class="btn btn-info me-md-2" target="_blank">
                                            <i
                                                class="bi bi-file-earmark-arrow-down"></i>{{ __('Download Identity License Card') }}
                                        </a>
                                    @endif
                                    @if ($order['Hr_Letter_Image'])
                                        <a href="{{ route('dashboard.files.download', $order['Hr_Letter_Image']) }}"
                                            class="btn btn-warning me-md-2" target="_blank">
                                            <i
                                                class="bi bi-file-earmark-arrow-down"></i>{{ __('Download License Hr Letter Image') }}
                                        </a>
                                    @endif
                                    @if ($order['Insurance_Image'])
                                        <a href="{{ route('dashboard.files.download', $order['Insurance_Image']) }}"
                                            class="btn btn-primary me-md-2" target="_blank">
                                            <i class="bi bi-file-earmark-arrow-down"></i>
                                            {{ __('Download Insurance Image') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
            </div>
            <!--end::Tab pane-->
            <!--begin::Tab pane-->
            <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
                <!--begin::Orders-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::Order history-->
                    <div class="card card-flush  flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Order History') }}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle text-center table-row-dashed fs-6 gy-5 mb-0">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="text-center text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-70px">{{ __('Order Status') }}</th>
                                            <th class="min-w-175px">{{ __('Comment') }}</th>
                                            <th class="min-w-100px">{{ __('employee') }}</th>
                                            <th class="min-w-100px">{{ __('assign to') }}</th>
                                            <th class="min-w-100px">{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">

                                        @foreach ($order->statusHistory as $record)
                                        @php
         $statusObj = getStatusObject($record['status']);
         

     @endphp

                                            <tr>

                                                <td>
                                                    <div class="badge"
                                                        style="background-color:{{ $statusObj['color'] }}">
                                                        @if($statusObj['name_ar'] == 1)
                                                    new

                                                    @endif
                                                    @if($statusObj['name_ar'] == 2)
                                                    processing
                                                    @endif
                                                    @if($statusObj['name_ar'] == 3)
                                                    accepted
                                                    @endif
                                                    @if($statusObj['name_ar'] == 4)
                                                    rejected
                                                    @endif
                                                    @if($statusObj['name_ar'] == 5)
                                                    please send your paper
                                                    @endif
                                                    @if($statusObj['name_ar'] == 6)
                                                    delivered
                                                 @endif                                                    
                                                    </div>
                                                </td>

                                                <td>{{ $record['comment'] ?? '-' }}</td>
                                                <td>{{ $record['employee']['name'] ??''}}</td>

                                                <td>{{ $record['assign']['name'] ?? '-' }}</td>

                                                <td>
                                                    {{ date('Y-m-d', strtotime($record['created_at'])) . ' / ' . date('H:i a', strtotime($record['created_at'])) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table head-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order history-->
                </div>
                <!--end::Orders-->
            </div>
            <!--end::Tab pane-->
        </div>
        <!--end::Tab content-->
    </div>


    <!--end::Order details page-->
@endsection
@push('styles')
    <style>
        .card-header {
            background-color: rgb(0, 74, 111) !important;
        }

        .card-header h2 {
            color: white !important;
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
<script>
    $('#order-status-sp').change(function () {

        const orderStatusId = {{ $order->status_id }};

        let newStatus = $(this).val();
        let id = newStatus.split('_')[0]; // Extract the order status ID
        let comment = '';
    
        inputAlert().then((result) => {
            comment = result.value[0] || '';
    
            if (result.isConfirmed) {
                // Check if a chassis exists for this order
                $.ajax({
                    url: `/dashboard/chassis/{{ $order['car_id'] }}`,
                    method: 'POST',
                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                     
                            data: {
                                order: {{ $order['id'] }}
                            },

                    success: (chassisData) => {
                        if (orderStatusId == '8'&&chassisData && chassisData.chassis.length === 0) {
                            
                                errorAlert('{{ __("There are no chassis available for this car") }}');

 
                            // If chassis exists, stop order status update and show an alert
                            return; // Exit the process
                        }
    
                        // If no chassis exists, proceed to change the order status
                        $.ajax({
                            url: "/dashboard/change-status/" + "{{ $order['id'] }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            data: {
                                status: id,
                                comment
                            },
                            success: (response) => {
                                successAlert('{{ __('status has been changed successfully') }}')
                                    .then(() => {
                                        // Check if the order status ID is 11 (cancellation)
                                        if (id === '11') { // Ensure the comparison is with string '11'
                                            $.ajax({
                                                url: `/dashboard/change/chassis/status/${id}`,
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                method: 'POST',
                                                data: {
                                                    order_status_id: id,
                                                    order: {{ $order['id'] }}
                                                },
                                                success: (statusResponse) => {
                                                    console.log("Chassis status updated successfully", statusResponse);
                                                    location.reload(); // Reload the page after successful update
                                                },
                                                error: (error) => {
                                                    console.log("Error updating chassis status:", error);
                                                }
                                            });
                                        } else{
                                            // Loop until a chassis is selected
                                            function requestChassisSelection() {
                                                $.ajax({
                                                    url: `/dashboard/chassis/{{ $order['car_id'] }}`,
                                                    method: 'POST',
                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    data: {
                                order: {{ $order['id'] }}
                            },
                                                    success: (chassisData) => {
                                                        if (!chassisData || chassisData.length === 0) {
                                                            errorAlert('{{ __("There are no chassis available for this car.") }}');
                                                            return; // Exit the function if no chassis is available
                                                        }
    
                                                        console.log('data', chassisData);

                                                            if(id=== '10'){
                                                        addchassis(chassisData).then((chassisResult) => {
                                if (chassisResult.isConfirmed && chassisResult.value.length > 0) {
                                const selectedChassis = chassisResult.value; // Array of selected chassis IDs

                                // Send selected chassis IDs to change their status
                                $.ajax({
                                    url: `/dashboard/change/chassis/status/${id}`,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'POST',
                                    data: {
                                        chassis_ids: selectedChassis, // Array of chassis IDs
                                        order_status_id: id,
                                        order: {{ $order['id'] }},
                                        comment
                                    },
                                    success: (response) => {
                                        console.log("Chassis statuses updated successfully:", response);
                                        successAlert('{{ __("Status has been changed successfully.") }}')
                                            .then(() => {
                                                location.reload(); // Reload the page after successful update
                                            });
                                    },
                                    error: (error) => {
                                        console.log("Error updating chassis statuses:", error);
                                        errorAlert('{{ __("An error occurred while updating chassis statuses.") }}');
                                    }
                                });
                            } else {
                                errorAlert('{{ __("Please select at least one chassis to proceed.") }}');
                            }
                        });



                    }else{
                        $.ajax({
                                    url: `/dashboard/change/chassis/status/${id}`,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'POST',
                                    data: {
                                         order_status_id: id,
                                        order: {{ $order['id'] }},
                                     },
                                    success: (response) => {
                                        console.log("Chassis statuses updated successfully:", response);
                                        successAlert('{{ __("Status has been changed successfully.") }}')
                                            .then(() => {
                                                location.reload(); // Reload the page after successful update
                                            });
                                    },
                                    error: (error) => {
                                        console.log("Error updating chassis statuses:", error);
                                        errorAlert('{{ __("An error occurred while updating chassis statuses.") }}');
                                    }
                                });
                    }

 
                                                    },
                                                    error: (error) => {
                                                        console.log("Error fetching chassis data:", error);
                                                    }
                                                });
                                            }
    
                                            // Start the chassis selection loop
                                            requestChassisSelection();
                                        }
                                    });
                            },
                            error: (error) => {
                                console.log(error);
                            },
                        });
                    },
                    error: (error) => {
                        console.log("Error checking chassis data:", error);
                    }
                });
            }
        });
    });
    </script>
        <script>
        $('#employee-sp').change(function() {
            let employee_id = $(this).val();
            let comment = '';

            inputAlert().then((result) => {

                comment = result.value[0] || '';

                if (result.isConfirmed) {
                    $.ajax({
                        url: "/dashboard/assigntoemployee/" + "{{ $order['id'] }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            employee_id: employee_id,
                            comment
                        },
                        success: (response) => {
                            successAlert(
                                    '{{ __('employees has been changed successfully') }}')
                                .then(() => window.location.reload())
                        },
                        error: (error) => {
                            console.log(error)
                        },

                    });
                }

            });


        });
    </script>
@endpush
