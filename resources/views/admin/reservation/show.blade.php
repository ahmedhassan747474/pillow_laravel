@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/invoice.css')}}">
@endsection
@section('page_title')
{{trans('common.reservation detail')}}  
@endsection
@section('content')

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p class="mb-0">
        {{session()->get('error')}}
    </p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
    </button>
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <p class="mb-0">
        {{session()->get('success')}}
    </p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
    </button>
</div>
@endif

<!-- invoice functionality start -->
<section class="invoice-print mb-1">
    <div class="row">

        {{-- <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Email" aria-describedby="button-addon2">
                <div class="input-group-append" id="button-addon2">
                    <button class="btn btn-outline-primary" type="button">Send Invoice</button>
                </div>
            </div>
        </fieldset> --}}
        <div class="col-12 col-md-12 d-flex flex-column flex-md-row justify-content-end">
            <button class="btn btn-primary btn-print mb-1 mb-md-0 ml-1"> <i class="feather icon-file-text"></i> {{trans('common.Print')}}</button>
            <button class="btn btn-success mb-1 mb-md-0 ml-1"> <i class="feather icon-file-text"></i> {{trans('common.Accept')}}</button>
            <button class="btn btn-danger mb-1 mb-md-0 ml-1"> <i class="feather icon-file-text"></i> {{trans('common.Reject')}}</button>
            <button class="btn btn-warning mb-1 mb-md-0 ml-1"> <i class="feather icon-file-text"></i> {{trans('common.Cancel')}}</button>
            {{-- <button class="btn btn-outline-primary  ml-0 ml-md-1"> <i class="feather icon-download"></i> Download</button> --}}
        </div>
    </div>
</section>
<!-- invoice functionality end -->
<!-- invoice page -->
<section class="card invoice-page">
    <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-sm-6 col-12 text-left pt-1">
                <div class="media pt-1">
                    <img src="{{asset('/admin_asset/app-assets/images/logo/logo.png')}}" alt="company logo" />
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h1>Invoice</h1>
                <div class="invoice-details mt-2">
                    <h6>INVOICE NO.</h6>
                    <p>{{$reservation['id']}}</p>
                    <h6 class="mt-2">INVOICE DATE</h6>
                    <p>{{$reservation['created_at']}}</p>
                </div>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Recipient Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-6 col-12 text-left">
                <h5>Recipient</h5>
                <div class="recipient-info my-2">
                    <p>{{$reservation['user_name']}}</p>
                    <p>{{$reservation['property_country_name']}}, {{$reservation['property_city_name']}}</p>
                    {{-- <p>Holbrook, NY</p>
                    <p>90001</p> --}}
                </div>
                <div class="recipient-contact pb-2">
                    <p>
                        <i class="feather icon-mail"></i>
                        {{$reservation['user_email']}}
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        (+{{$reservation['user_phone_code']}}){{$reservation['user_phone_number']}}
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-12 text-right">
                <h5>{{$reservation['property_name']}}</h5>
                <div class="company-info my-2">
                    <p>9 N. Sherwood Court</p>
                    <p>Elyria, OH</p>
                    <p>94203</p>
                </div>
                <div class="company-contact">
                    <p>
                        <i class="feather icon-mail"></i>
                        hello@pixinvent.net
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        +91 999 999 9999
                    </p>
                </div>
            </div>
        </div>
        <!--/ Invoice Recipient Details -->

        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-1 invoice-items-table">
            <div class="row">
                <div class="table-responsive col-12">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>TASK DESCRIPTION</th>
                                <th>HOURS</th>
                                <th>RATE</th>
                                <th>AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Website Redesign</td>
                                <td>60</td>
                                <td>15 USD</td>
                                <td>90000 USD</td>
                            </tr>
                            <tr>
                                <td>Newsletter template design</td>
                                <td>20</td>
                                <td>12 USD</td>
                                <td>24000 USD</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="invoice-total-details" class="invoice-total-table">
            <div class="row">
                <div class="col-7 offset-5">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td>114000 USD</td>
                                </tr>
                                <tr>
                                    <th>DISCOUNT (5%)</th>
                                    <td>5700 USD</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td>108300 USD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Footer -->
        <div id="invoice-footer" class="text-right pt-3">
            <p>Transfer the amounts to the business amount below. Please include invoice number on your check.
            <p class="bank-details mb-0">
                <span class="mr-4">BANK: <strong>FTSBUS33</strong></span>
                <span>IBAN: <strong>G882-1111-2222-3333</strong></span>
            </p>
        </div>
        <!--/ Invoice Footer -->

    </div>
</section>
<!-- invoice page end -->

@endsection

@section('script')
<script src="{{asset('/admin_asset/app-assets/js/scripts/pages/invoice.js')}}"></script>
<script>
$(document).on('change', '.toggle-class', function() {
    var status = $(this).prop('checked') == true ? 1 : 0; 
    var id = $(this).data('id'); 
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('block_reason')}}",
        data: {'status': status, 'id': id},
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1000
            })
        }
    });
})

$(document).on('click', '.delete-ajax', function() {
    var url = $(this).data('url');
    var direct = $(this).data('direct');
    Swal.fire({
        title: "{{trans('common.Are you sure?')}}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{trans('common.Yes, delete it')}}"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data){
                    Swal.fire({
                        icon: 'success',
                        title: "{{trans('common.Deleted Successfully')}}",
                        showConfirmButton: false
                    })
                    setTimeout(function () {
                        window.location.href = direct;
                    }, 2000);
                }
            });
        }
    })
})
</script>
@endsection