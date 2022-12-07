@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/card-analytics.css')}}">
@endsection
@section('page_title')
Dashboard
@endsection
@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    {{-- <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <img src="{{asset('/admin_asset/app-assets/images/elements/decore-left.png')}}" class="img-left" alt="card-img-left">
                        <img src="{{asset('/admin_asset/app-assets/images/elements/decore-right.png')}}" class="img-right" alt="card-img-right">
                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                            <div class="avatar-content">
                                <i class="feather icon-award white font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-2 text-white">Congratulations John,</h1>
                            <p class="m-auto w-75">You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-users text-primary font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $results['allUsers'] }}</h2>
                    <p class="mb-0">{{trans('common.All') . ' ' .trans('common.users')}}</p>
                </div>
                <div class="card-content">
                    <div id="subscribe-gain-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-package text-warning font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">{{ $results['totalReservation'] }}</h2>
                    <p class="mb-0">{{trans('common.offers')}} Received</p>
                </div>
                <div class="card-content">
                    <div id="orders-received-chart"></div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>1]) }}">
                                <i class="feather icon-home text-primary font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['hotels'] }}</h2>
                    <p class="mb-0">{{ trans('common.All') .' '.trans('common.Apartment') }}</p>
                </div>
                <div class="card-content">
                    <div id="hotels"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>3]) }}">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['shared_room'] }}</h2>
                    <p class="mb-0">{{ trans('common.All') .' '.trans('common.Administrative') }}</p>
                </div>
                <div class="card-content">
                    <div id="rooms"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>2]) }}">
                            <i class="feather icon-home text-danger font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['furnished'] }}</h2>
                    <p class="mb-0">{{ trans('common.Villa') }}</p>
                </div>
                <div class="card-content">
                    <div id="furnished_Apartment"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>4]) }}">
                                <i class="feather icon-home text-warning font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['restaurant'] }}</h2>
                    <p class="mb-0">{{ trans('common.Shop') }}</p>
                </div>
                <div class="card-content">
                    <div id="restaurant"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>5]) }}">
                            <i class="feather icon-loader text-danger font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['widding'] }}</h2>
                    <p class="mb-0">{{ trans('common.Chalet') }}</p>
                </div>
                <div class="card-content">
                    <div id="wedding_hall"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>6]) }}">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['travel'] }}</h2>
                    <p class="mb-0">{{ trans('common.Land') }}</p>
                </div>
                <div class="card-content">
                    <div id="travel_agency"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>8]) }}">
                            <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['residential'] }}</h2>
                    <p class="mb-0">{{ trans('common.Factories') }}</p>
                </div>
                <div class="card-content">
                    <div id="residential"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <a href="{{ route('dashboard.detailsChart', ['type'=>7]) }}">
                            <i class="feather icon-home text-primary font-medium-5"></i>
                            </a>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">{{ $results['business'] }}</h2>
                    <p class="mb-0">{{ trans('common.Farms') }}</p>
                </div>
                <div class="card-content">
                    <div id="business"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" style="height: 530px">
                        <div class="row pb-50">
                            <div class="col-lg-6 col-12 d-flex justify-content-between flex-column order-lg-1 order-2 mt-lg-0 mt-2">
                                <div>
                                    <h2 class="text-bold-700 mb-25">{{ $results['reservationsLast7DaysCounter']->count() }}</h2>
                                    <p class="text-bold-500 mb-75">{{ trans('common.offers') }}</p>
                                    <h5 class="font-medium-2">
                                        <span class="text-success">{{ $results['reservationsLast7DaysCounter']->count() }} </span>
                                        <span>اخر 7 ايام</span>
                                    </h5>
                                </div>
                                {{-- <a href="#" class="btn btn-primary shadow">View Details <i class="feather icon-chevrons-right"></i></a> --}}
                            </div>
                            <div class="col-lg-6 col-12 d-flex justify-content-between flex-column text-right order-lg-2 order-1">
                                <div class="dropdown chart-dropdown">
                                    {{-- <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Last 7 Days
                                    </button> --}}
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                                <div id="avg-session-chart"></div>
                            </div>
                        </div>
                        <hr />
                        <div class="row avg-sessions pt-50">
                            <div class="col-6">
                                <p class="mb-0">{{ trans('common.Canceled') }}: {{ $results['reservationsLast7DaysCounter']->where('status', '=', '4')->count() }}</p>
                                <div class="progress progress-bar-primary mt-25">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="70" aria-valuemax="100" style="width:{{ $results['reservationsLast7DaysCounter']->where('status', '=', '4')->count() == 0 ? 0 : $results['reservationsLast7DaysCounter']->where('status', '=', '4')->count() * 100 / $results['reservationsLast7DaysCounter']->count()}}%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">{{ trans('common.Pending') }}: {{ $results['reservationsLast7DaysCounter']->where('status', '=', '1')->count() }}</p>
                                <div class="progress progress-bar-warning mt-25">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width:{{ $results['reservationsLast7DaysCounter']->where('status', '=', '1')->count() == 0 ? 0 : $results['reservationsLast7DaysCounter']->where('status', '=', '1')->count() * 100 / $results['reservationsLast7DaysCounter']->count()}}%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">{{ trans('common.Rejected') }}: {{ $results['reservationsLast7DaysCounter']->where('status', '=', '3')->count() }}</p>
                                <div class="progress progress-bar-danger mt-25">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70" aria-valuemax="100" style="width:{{ $results['reservationsLast7DaysCounter']->where('status', '=', '3')->count() == 0 ? 0 : $results['reservationsLast7DaysCounter']->where('status', '=', '3')->count() * 100 / $results['reservationsLast7DaysCounter']->count()}}%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-0">{{ trans('common.Accepted') }}: {{ $results['reservationsLast7DaysCounter']->where('status', '=', '2')->count() }}</p>
                                <div class="progress progress-bar-success mt-25">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90" aria-valuemax="100" style="width:{{ $results['reservationsLast7DaysCounter']->where('status', '=', '2')->count() == 0 ? 0 : $results['reservationsLast7DaysCounter']->where('status', '=', '2')->count() * 100 / $results['reservationsLast7DaysCounter']->count()}}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4 class="card-title">Support Tracker</h4>
                    <div class="dropdown chart-dropdown">
                        <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
                            <a class="dropdown-item" href="#">Last 28 Days</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                <h1 class="font-large-2 text-bold-700 mt-2 mb-0">163</h1>
                                <small>Tickets</small>
                            </div>
                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                <div id="support-tracker-chart"></div>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between">
                            <div class="text-center">
                                <p class="mb-50">New Tickets</p>
                                <span class="font-large-1">29</span>
                            </div>
                            <div class="text-center">
                                <p class="mb-50">Open Tickets</p>
                                <span class="font-large-1">63</span>
                            </div>
                            <div class="text-center">
                                <p class="mb-50">Response Time</p>
                                <span class="font-large-1">1d</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>{{ trans('common.offers') }}</h4>
                    <div class="dropdown chart-dropdown">
                        {{-- <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button> --}}
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem2">
                            <a class="dropdown-item" href="#">Last 28 Days</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="product-order-chart" class="mb-3"></div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{ trans('common.Accepted') }}</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['accept'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">{{ trans('common.Pending') }}</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['pending'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-75">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">{{ trans('common.Rejected') }}</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['reject'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">{{ trans('common.Canceled') }}</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['cancel'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title">{{ trans('common.All') . ' '.trans('common.users') }}</h4>
                        <p class="text-muted mt-25 mb-0">اخر 6 شهور</p>
                    </div>
                    <p class="mb-0"><i class="feather icon-more-vertical font-medium-3 text-muted cursor-pointer"></i></p>
                </div>
                <div class="card-content">
                    <div class="card-body px-0">
                        <div id="sales-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row match-height">
        {{-- <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4>{{ trans('common.offers') }}</h4>
                    <div class="dropdown chart-dropdown">
                        <!-- <button class="btn btn-sm border-0 dropdown-toggle p-0" type="button" id="dropdownItem2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button> -->
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem2">
                            <a class="dropdown-item" href="#">Last 28 Days</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="product-order-chart" class="mb-3"></div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">Accepted</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['accept'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-warning"></i>
                                <span class="text-bold-600 ml-50">Pending</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['pending'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-75">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-danger"></i>
                                <span class="text-bold-600 ml-50">Rejected</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['reject'] }}</span>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="fa fa-circle-o text-bold-700 text-primary"></i>
                                <span class="text-bold-600 ml-50">Canceled</span>
                            </div>
                            <div class="product-result">
                                <span>{{ $results['cancel'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title">{{ trans('common.All') . ' '.trans('common.users') }}</h4>
                        <p class="text-muted mt-25 mb-0">Last 6 months</p>
                    </div>
                    <p class="mb-0"><i class="feather icon-more-vertical font-medium-3 text-muted cursor-pointer"></i></p>
                </div>
                <div class="card-content">
                    <div class="card-body px-0">
                        <div id="sales-chart"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activity Timeline</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="activity-timeline timeline-left list-unstyled">
                            <li>
                                <div class="timeline-icon bg-primary">
                                    <i class="feather icon-plus font-medium-2 align-middle"></i>
                                </div>
                                <div class="timeline-info">
                                    <p class="font-weight-bold mb-0">Client Meeting</p>
                                    <span class="font-small-3">Bonbon macaroon jelly beans gummi bears jelly lollipop apple</span>
                                </div>
                                <small class="text-muted">25 mins ago</small>
                            </li>
                            <li>
                                <div class="timeline-icon bg-warning">
                                    <i class="feather icon-alert-circle font-medium-2 align-middle"></i>
                                </div>
                                <div class="timeline-info">
                                    <p class="font-weight-bold mb-0">Email Newsletter</p>
                                    <span class="font-small-3">Cupcake gummi bears soufflé caramels candy</span>
                                </div>
                                <small class="text-muted">15 days ago</small>
                            </li>
                            <li>
                                <div class="timeline-icon bg-danger">
                                    <i class="feather icon-check font-medium-2 align-middle"></i>
                                </div>
                                <div class="timeline-info">
                                    <p class="font-weight-bold mb-0">Plan Webinar</p>
                                    <span class="font-small-3">Candy ice cream cake. Halvah gummi bears</span>
                                </div>
                                <small class="text-muted">20 days ago</small>
                            </li>
                            <li>
                                <div class="timeline-icon bg-success">
                                    <i class="feather icon-check font-medium-2 align-middle"></i>
                                </div>
                                <div class="timeline-info">
                                    <p class="font-weight-bold mb-0">Launch Website</p>
                                    <span class="font-small-3">Candy ice cream cake. </span>
                                </div>
                                <small class="text-muted">25 days ago</small>
                            </li>
                            <li>
                                <div class="timeline-icon bg-primary">
                                    <i class="feather icon-check font-medium-2 align-middle"></i>
                                </div>
                                <div class="timeline-info">
                                    <p class="font-weight-bold mb-0">Marketing</p>
                                    <span class="font-small-3">Candy ice cream. Halvah bears Cupcake gummi bears.</span>
                                </div>
                                <small class="text-muted">28 days ago</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ trans('common.offers') }}</h4>
                </div>
                <div class="card-content">
                    <div class="table-responsive mt-1" style="overflow: unset;">
                        <table class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th>{{trans('common.Order')}}</th>
                                    <th>{{trans('common.Status')}}</th>
                                    <th>{{trans('common.Name')}}</th>
                                    <th>{{trans('common.User Name')}}</th>
                                    <th>{{trans('common.Date')}}</th>
                                    <th>{{trans('common.Price')}}</th>
                                    <th>{{trans('common.Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results['allReservations'] as $reservation)
                                <tr>
                                    <td>#{{$reservation['id']}}</td>
                                    @if($reservation['status'] == 1)
                                    <td><i class="fa fa-circle font-small-3 text-warning mr-50"></i>{{$reservation['status_name']}}</td>
                                    @elseif($reservation['status'] == 2)
                                    <td><i class="fa fa-circle font-small-3 text-success mr-50"></i>{{$reservation['status_name']}}</td>
                                    @elseif($reservation['status'] == 3)
                                    <td><i class="fa fa-circle font-small-3 text-danger mr-50"></i>{{$reservation['status_name']}}</td>
                                    @else
                                    <td><i class="fa fa-circle font-small-3 text-danger mr-50"></i>{{$reservation['status_name']}}</td>
                                    @endif
                                    <td>{{$reservation['property_name']}}</td>
                                    <td>{{$reservation['user_name']}}</td>
                                    <td>{{$reservation['created_at']}}</td>
                                    <td>{{$reservation['final_price']}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-primary dropdown-toggle mr-1 mb-1" type="button" id="dropdownMenuButton{{$reservation['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{trans('common.Actions')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$reservation['id']}}">
                                                    <a class="dropdown-item" href="{{route('show_reservation', $reservation['id'])}}">{{trans('common.Show')}}</a>
                                                    @if ($reservation['status'] == 1)
                                                    <a class="dropdown-item" href="{{route('accept_reservation', $reservation['id'])}}">{{trans('common.Accept')}}</a>
                                                    <a class="dropdown-item" href="{{route('reject_reservation', $reservation['id'])}}">{{trans('common.Reject')}}</a>
                                                    <a class="dropdown-item" href="{{route('cancel_reservation', $reservation['id'])}}">{{trans('common.Cancel')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</section>
{{-- <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $results['reservationsData']->links() }}
    </ul>
</nav> --}}
<!-- Dashboard Analytics end -->
@endsection

@section('script')
<script src="{{asset('/admin_asset/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/tether.min.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/shepherd.min.js')}}"></script>

<script src="{{asset('/admin_asset/app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script>

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
            name: "{{trans('common.offers')}}",
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

