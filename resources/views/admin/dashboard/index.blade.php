@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/card-analytics.css')}}">
@endsection
@section('page_title')
Dashboard
@endsection
@section('content')
<!-- Statistics card section start -->
<section id="statistics-card">
    <div class="row">

        <div class="col-lg-4 col-md-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">{{trans('common.users')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-50">
                        <div id="users-chart" class="mb-2"></div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.All')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['allUsers']}}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.users')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['users']}}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.rides')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['rides']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">{{trans('common.properties')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-50">
                        <div id="properties-chart" class="mb-2"></div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Hotels')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['hotels']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Furnished Apartment')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['furnished']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Shared Room')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['shared_room']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-info"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Restaurant')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['restaurant']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Wedding Hall')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['widding']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Travel Agency')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['travel']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Business Space')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['business']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-info"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Residential')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['residential']}}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">{{trans('common.reservations')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pt-50">
                        <div id="reservations-chart" class="mb-2"></div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Hotels')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['hotelReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Furnished Apartment')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['furnishedReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Shared Room')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['sharedRoomReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-info"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Restaurant')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['restaurantReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Wedding Hall')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['weddingReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Travel Agency')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['travelReservation']}}</span>
                            </div>
                        </div>

                        <div class="chart-info d-flex justify-content-between mb-25">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{trans('common.Business Space')}}</span>
                            </div>
                            <div class="product-result">
                                <span>{{$results['businessReservation']}}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">{{trans('common.properties')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="property-line-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">{{trans('common.reservations')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div id="reservation-line-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        @if(checkPermit('is_user'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-eye text-info font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['users']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.users')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_ride'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-eye text-info font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['rides']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.rides')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_hotel'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['hotels']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Hotels')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_furnished'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['furnished']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Furnished Apartment')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_shared'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['shared_room']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Shared Room')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_restaurant'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['restaurant']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Restaurant')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_wedding'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['widding']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Wedding Hall')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_travel'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['travel']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Travel Agency')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_business'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['business']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Business Space')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_car'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['car']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Car')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_residential'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-heart text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['residential']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Residential')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_attributes'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['attributes']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Attributes')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_book_list'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['book_list']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Book List')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_through'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['through']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Through')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_include'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['include']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Include')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_residential_type'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['type']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Residential Type')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_country'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['country']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Country')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_city'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['city']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.City')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_reason'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['reason']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Reason')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_coupon'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['coupon']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Coupon')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_property'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-message-square text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['property']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Property')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(checkPermit('is_reservation'))
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['totalReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Total Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['carReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Car Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['hotelReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Hotel Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['furnishedReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Furnished Apartment Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['sharedRoomReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Shared Room Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['restaurantReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Restaurant Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['weddingReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Wedding Hall Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['travelReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Travel Agency Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['businessReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Business Space Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-danger p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-bag text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['residentialReservation']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Residential Reservation')}}</p>
                    </div>
                </div>
            </div>
        </div> --}}
        @endif

        @if(auth()->guard('admin')->user()->type == '1')
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-award text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['total_rate']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Total Rate')}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center">
                <div class="card-content">
                    <div class="card-body">
                        <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                            <div class="avatar-content">
                                <i class="feather icon-award text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700">{{$results['total_review']}}</h2>
                        <p class="mb-0 line-ellipsis">{{trans('common.Total Review')}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
<!-- // Statistics Card section end-->
@endsection

@section('script')
<script src="{{asset('/admin_asset/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>

<script>

    var $primary = '#7367F0';
    var $danger = '#EA5455';
    var $warning = '#FF9F43';
    var $info = '#00cfe8';
    var $success = '#00db89';
    var $primary_light = '#9c8cfc';
    var $warning_light = '#FFC085';
    var $danger_light = '#f29292';
    var $info_light = '#1edec5';
    var $strok_color = '#b9c3cd';
    var $label_color = '#e7eef7';
    var $purple = '#df87f2';
    var $white = '#fff';

    // Users Chart
    // -----------------------------

    var userChartoptions = {
        chart: {
            height: 500,
            type: 'radialBar',
        },
        colors: [$primary, $warning, $danger],
        fill: {
            type: 'gradient',
            gradient: {
                // enabled: true,
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.5,
                gradientToColors: [$primary_light, $warning_light, $danger_light],
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            },
        },
        stroke: {
            lineCap: 'round'
        },
        plotOptions: {
            radialBar: {
              size: 246,
                hollow: {
                    size: '20%'
                },
                track: {
                    strokeWidth: '100%',
                    margin: 15,
                },
                dataLabels: {
                    name: {
                        fontSize: '18px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: "All",

                        formatter: function (w) {
                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                            return "{{$results['allUsers']}}"
                        }
                    }
                }
            }
        },
        series: ["{{$results['allUsers']}}", "{{$results['users']}}", "{{$results['rides']}}"],
        labels: ["{{trans('common.All')}}", "{{trans('common.users')}}", "{{trans('common.rides')}}"],

    }

    var userChart = new ApexCharts(
        document.querySelector("#users-chart"),
        userChartoptions
    );

    userChart.render();

    // Properties Chart
    // -----------------------------

    var propertyChartoptions = {
        chart: {
            height: 500,
            type: 'radialBar',
        },
        colors: [$primary, $warning, $danger, $info, $success, $primary_light, $warning_light, $info_light],
        fill: {
            type: 'gradient',
            gradient: {
                // enabled: true,
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.5,
                gradientToColors: [$primary_light, $warning_light, $danger_light, $info_light, $white, $primary, $warning, $info],
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            },
        },
        stroke: {
            lineCap: 'round'
        },
        plotOptions: {
            radialBar: {
              size: 200,
                hollow: {
                    size: '15%'
                },
                track: {
                    strokeWidth: '100%',
                    margin: 15,
                },
                dataLabels: {
                    name: {
                        fontSize: '18px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: "All",

                        formatter: function (w) {
                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                            return "{{$results['allProperties']}}"
                        }
                    }
                }
            }
        },
        series: [
            "{{$results['hotels']}}",
            "{{$results['furnished']}}",
            "{{$results['shared_room']}}",
            "{{$results['restaurant']}}",
            "{{$results['widding']}}",
            "{{$results['travel']}}",
            "{{$results['business']}}",
            "{{$results['residential']}}",
        ],
        labels: [
            "{{trans('common.Hotels')}}",
            "{{trans('common.Furnished Apartment')}}",
            "{{trans('common.Shared Room')}}",
            "{{trans('common.Restaurant')}}",
            "{{trans('common.Wedding Hall')}}",
            "{{trans('common.Travel Agency')}}",
            "{{trans('common.Business Space')}}",
            "{{trans('common.Residential')}}",
        ],

    }

    var propertyChart = new ApexCharts(
        document.querySelector("#properties-chart"),
        propertyChartoptions
    );

    propertyChart.render();

    // Reservations Chart
    // -----------------------------

    var reservationChartoptions = {
        chart: {
            height: 500,
            type: 'radialBar',
        },
        colors: [$primary, $warning, $danger, $info, $success, $primary_light, $warning_light],
        fill: {
            type: 'gradient',
            gradient: {
                // enabled: true,
                shade: 'dark',
                type: 'vertical',
                shadeIntensity: 0.5,
                gradientToColors: [$primary_light, $warning_light, $danger_light, $info_light, $white, $primary, $warning],
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
            },
        },
        stroke: {
            lineCap: 'round'
        },
        plotOptions: {
            radialBar: {
              size: 211,
                hollow: {
                    size: '15%'
                },
                track: {
                    strokeWidth: '100%',
                    margin: 15,
                },
                dataLabels: {
                    name: {
                        fontSize: '18px',
                    },
                    value: {
                        fontSize: '16px',
                    },
                    total: {
                        show: true,
                        label: "All",

                        formatter: function (w) {
                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                            return "{{$results['totalReservation']}}"
                        }
                    }
                }
            }
        },
        series: [
            "{{$results['hotelReservation']}}",
            "{{$results['furnishedReservation']}}",
            "{{$results['sharedRoomReservation']}}",
            "{{$results['restaurantReservation']}}",
            "{{$results['weddingReservation']}}",
            "{{$results['travelReservation']}}",
            "{{$results['businessReservation']}}",
        ],
        labels: [
            "{{trans('common.Hotels')}}",
            "{{trans('common.Furnished Apartment')}}",
            "{{trans('common.Shared Room')}}",
            "{{trans('common.Restaurant')}}",
            "{{trans('common.Wedding Hall')}}",
            "{{trans('common.Travel Agency')}}",
            "{{trans('common.Business Space')}}",
        ],

    }

    var reservationChart = new ApexCharts(
        document.querySelector("#reservations-chart"),
        reservationChartoptions
    );

    reservationChart.render();

    // Property Chart
    // -----------------------------

   var propertyavgChartoptions = {
        chart: {
            height: 270,
            toolbar: { show: false },
            type: 'line',
            dropShadow: {
                enabled: true,
                top: 20,
                left: 2,
                blur: 6,
                opacity: 0.20
            },
        },
        stroke: {
            curve: 'smooth',
            width: 4,
        },
        grid: {
            borderColor: $label_color,
        },
        legend: {
            show: false,
        },
        colors: [$purple],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                inverseColors: false,
                gradientToColors: [$primary],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            },
        },
        markers: {
            size: 0,
            hover: {
                size: 5
            }
        },
        xaxis: {
            labels: {
                style: {
                    colors: $strok_color,
                }
            },
            axisTicks: {
                show: false,
            },
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: {
                show: false,
            },
            tickPlacement: 'on'
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                style: {
                    color: $strok_color,
                },
                formatter: function(val) {
                    return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                }
            }
        },
        tooltip: {
            x: { show: false }
        },
        series: [{
            name: "{{trans('common.properties')}}",
            data: {{$results['propertyLineChart']}}
        }],

    }

   var propertyavgChart = new ApexCharts(
        document.querySelector("#property-line-chart"),
        propertyavgChartoptions
    );

    propertyavgChart.render();

    // Reservation Chart
    // -----------------------------

   var reservationavgChartoptions = {
        chart: {
            height: 270,
            toolbar: { show: false },
            type: 'line',
            dropShadow: {
                enabled: true,
                top: 20,
                left: 2,
                blur: 6,
                opacity: 0.20
            },
        },
        stroke: {
            curve: 'smooth',
            width: 4,
        },
        grid: {
            borderColor: $label_color,
        },
        legend: {
            show: false,
        },
        colors: [$purple],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                inverseColors: false,
                gradientToColors: [$primary],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            },
        },
        markers: {
            size: 0,
            hover: {
                size: 5
            }
        },
        xaxis: {
            labels: {
                style: {
                    colors: $strok_color,
                }
            },
            axisTicks: {
                show: false,
            },
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: {
                show: false,
            },
            tickPlacement: 'on'
        },
        yaxis: {
            tickAmount: 4,
            labels: {
                style: {
                    color: $strok_color,
                },
                formatter: function(val) {
                    return val > 999 ? (val / 1000).toFixed(1) + 'k' : val;
                }
            }
        },
        tooltip: {
            x: { show: false }
        },
        series: [{
            name: "{{trans('common.reservations')}}",
            data: {{$results['reservationLineChart']}}
        }],

    }

   var reservationavgChart = new ApexCharts(
        document.querySelector("#reservation-line-chart"),
        reservationavgChartoptions
    );

    reservationavgChart.render();
</script>
@endsection

