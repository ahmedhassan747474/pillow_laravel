@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/dashboard-ecommerce.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/card-analytics.css')}}">
@endsection
@section('page_title')
Dashboard
@endsection
@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-primary p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-users text-primary font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">92.6k</h2>
                    <p class="mb-0">Subscribers Gained</p>
                </div>
                <div class="card-content">
                    <div id="line-area-chart-1"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-success p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-credit-card text-success font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">97.5k</h2>
                    <p class="mb-0">Revenue Generated</p>
                </div>
                <div class="card-content">
                    <div id="line-area-chart-2"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-danger p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">36%</h2>
                    <p class="mb-0">Quarterly Sales</p>
                </div>
                <div class="card-content">
                    <div id="line-area-chart-3"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-package text-warning font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1">97.5K</h2>
                    <p class="mb-0">Orders Received</p>
                </div>
                <div class="card-content">
                    <div id="line-area-chart-4"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="card-title">Revenue</h4>
                    <p class="font-medium-5 mb-0"><i class="feather icon-settings text-muted cursor-pointer"></i></p>
                </div>
                <div class="card-content">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-start">
                            <div class="mr-2">
                                <p class="mb-50 text-bold-600">This Month</p>
                                <h2 class="text-bold-400">
                                    <sup class="font-medium-1">$</sup>
                                    <span class="text-success">86,589</span>
                                </h2>
                            </div>
                            <div>
                                <p class="mb-50 text-bold-600">Last Month</p>
                                <h2 class="text-bold-400">
                                    <sup class="font-medium-1">$</sup>
                                    <span>73,683</span>
                                </h2>
                            </div>

                        </div>
                        <div id="revenue-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4 class="mb-0">Goal Overview</h4>
                    <p class="font-medium-5 mb-0"><i class="feather icon-help-circle text-muted cursor-pointer"></i></p>
                </div>
                <div class="card-content">
                    <div class="card-body px-0 pb-0">
                        <div id="goal-overview-chart" class="mt-75"></div>
                        <div class="row text-center mx-0">
                            <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
                                <p class="mb-50">Completed</p>
                                <p class="font-large-1 text-bold-700">786,617</p>
                            </div>
                            <div class="col-6 border-top d-flex align-items-between flex-column py-1">
                                <p class="mb-50">In Progress</p>
                                <p class="font-large-1 text-bold-700">13,561</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Browser Statistics</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-25">
                            <div class="browser-info">
                                <p class="mb-25">Google Chrome</p>
                                <h4>73%</h4>
                            </div>
                            <div class="stastics-info text-right">
                                <span>800 <i class="feather icon-arrow-up text-success"></i></span>
                                <span class="text-muted d-block">13:16</span>
                            </div>
                        </div>
                        <div class="progress progress-bar-primary mb-2">
                            <div class="progress-bar" role="progressbar" aria-valuenow="73" aria-valuemin="73" aria-valuemax="100" style="width:73%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-25">
                            <div class="browser-info">
                                <p class="mb-25">Opera</p>
                                <h4>8%</h4>
                            </div>
                            <div class="stastics-info text-right">
                                <span>-200 <i class="feather icon-arrow-down text-danger"></i></span>
                                <span class="text-muted d-block">13:16</span>
                            </div>
                        </div>
                        <div class="progress progress-bar-primary mb-2">
                            <div class="progress-bar" role="progressbar" aria-valuenow="8" aria-valuemin="8" aria-valuemax="100" style="width:8%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-25">
                            <div class="browser-info">
                                <p class="mb-25">Firefox</p>
                                <h4>19%</h4>
                            </div>
                            <div class="stastics-info text-right">
                                <span>100 <i class="feather icon-arrow-up text-success"></i></span>
                                <span class="text-muted d-block">13:16</span>
                            </div>
                        </div>
                        <div class="progress progress-bar-primary mb-2">
                            <div class="progress-bar" role="progressbar" aria-valuenow="19" aria-valuemin="19" aria-valuemax="100" style="width:19%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-25">
                            <div class="browser-info">
                                <p class="mb-25">Internet Explorer</p>
                                <h4>27%</h4>
                            </div>
                            <div class="stastics-info text-right">
                                <span>-450 <i class="feather icon-arrow-down text-danger"></i></span>
                                <span class="text-muted d-block">13:16</span>
                            </div>
                        </div>
                        <div class="progress progress-bar-primary mb-50">
                            <div class="progress-bar" role="progressbar" aria-valuenow="27" aria-valuemin="27" aria-valuemax="100" style="width:27%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Client Retention</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="client-retention-chart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end">
                    <h4>Sessions By Device</h4>
                    <div class="dropdown chart-dropdown">
                        <button class="btn btn-sm border-0 dropdown-toggle px-0" type="button" id="dropdownItem1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem1">
                            <a class="dropdown-item" href="#">Last 28 Days</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body pt-0">
                        <div id="session-chart" class="mb-1"></div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="feather icon-monitor font-medium-2 text-primary"></i>
                                <span class="text-bold-600 mx-50">Desktop</span>
                                <span> - 58.6%</span>
                            </div>
                            <div class="series-result">
                                <span>2%</span>
                                <i class="feather icon-arrow-up text-success"></i>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-1">
                            <div class="series-info d-flex align-items-center">
                                <i class="feather icon-tablet font-medium-2 text-warning"></i>
                                <span class="text-bold-600 mx-50">Mobile</span>
                                <span> - 34.9%</span>
                            </div>
                            <div class="series-result">
                                <span>8%</span>
                                <i class="feather icon-arrow-up text-success"></i>
                            </div>
                        </div>
                        <div class="chart-info d-flex justify-content-between mb-50">
                            <div class="series-info d-flex align-items-center">
                                <i class="feather icon-tablet font-medium-2 text-danger"></i>
                                <span class="text-bold-600 mx-50">Tablet</span>
                                <span> - 6.5%</span>
                            </div>
                            <div class="series-result">
                                <span>-5%</span>
                                <i class="feather icon-arrow-down text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card chat-application">
                <div class="card-header">
                    <h4 class="card-title">Chat</h4>
                </div>
                <div class="chat-app-window">
                    <div class="user-chats">
                        <div class="chats">
                            <div class="chat">
                                <div class="chat-avatar">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-2.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Cake sesame snaps cupcake gingerbread</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat chat-left">
                                <div class="chat-avatar mt-50">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-5.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Apple pie pie jujubes chupa chups muffin</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat">
                                <div class="chat-avatar">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-2.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Chocolate cake</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat chat-left">
                                <div class="chat-avatar mt-50">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-5.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Donut sweet pie oat cake dragée fruitcake</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat">
                                <div class="chat-avatar mt-50">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-2.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Liquorice chocolate bar jelly beans icing</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat chat-left">
                                <div class="chat-avatar mt-50">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-5.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Powder toffee tootsie roll macaroon cupcake.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat">
                                <div class="chat-avatar">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-2.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Apple pie oat cake brownie cotton candy cupcake chocolate bar dessert.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chat chat-left">
                                <div class="chat-avatar mt-50">
                                    <a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title="">
                                        <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-5.jpg')}}" alt="avatar" height="40" width="40" />
                                    </a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-content">
                                        <p>Biscuit cake jujubes carrot cake topping sweet cake.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="card-body d-flex justify-content-around pt-0">
                            <input type="text" class="form-control mr-50" placeholder="Type your Message">
                            <button type="button" class="btn btn-icon btn-primary"><i class="feather icon-navigation"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4 class="card-title">Customers</h4>
                    <div class="dropdown chart-dropdown">
                        <button class="btn btn-sm border-0 dropdown-toggle px-0" type="button" id="dropdownItem3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem3">
                            <a class="dropdown-item" href="#">Last 28 Days</a>
                            <a class="dropdown-item" href="#">Last Month</a>
                            <a class="dropdown-item" href="#">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body py-0">
                        <div id="customer-chart"></div>
                    </div>
                    <ul class="list-group list-group-flush customer-info">
                        <li class="list-group-item d-flex justify-content-between ">
                            <div class="series-info">
                                <i class="fa fa-circle font-small-3 text-primary"></i>
                                <span class="text-bold-600">New</span>
                            </div>
                            <div class="product-result">
                                <span>890</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ">
                            <div class="series-info">
                                <i class="fa fa-circle font-small-3 text-warning"></i>
                                <span class="text-bold-600">Returning</span>
                            </div>
                            <div class="product-result">
                                <span>258</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between ">
                            <div class="series-info">
                                <i class="fa fa-circle font-small-3 text-danger"></i>
                                <span class="text-bold-600">Referrals</span>
                            </div>
                            <div class="product-result">
                                <span>149</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('script')
<script src="{{asset('/admin_asset/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/tether.min.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/shepherd.min.js')}}"></script>

<script src="{{asset('/admin_asset/app-assets/js/scripts/pages/dashboard-ecommerce.js')}}"></script>

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

