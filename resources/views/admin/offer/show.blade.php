@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/app-user.css')}}">
@endsection
@section('page_title')
{{trans('common.offer detail')}}
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

<!-- page users view start -->
<section class="page-users-view">
    <div class="row">
        <!-- account start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{trans('common.Offer')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="users-view-image">
                            <img src="{{$offer->image}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div> --}}
                        <div class="col-12 col-sm-9 col-md-4 col-lg-4">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Commission')}}: </td>
                                    <td>{{$offer->commission}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Commission Negotiate')}}: </td>
                                    <td>{{$offer->commission_negotiate == 0 ?'No':'Yes'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.price')}}:</td>
                                    <td> {{$offer->price}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td>
                                        @if ($offer->status==1)
                                            {{ trans('common.Pending') }}
                                            @elseif ($offer->status==2)
                                            {{ trans('common.Accepted') }}
                                            @elseif ($offer->status==3)
                                            {{ trans('common.Rejected') }}
                                            @elseif ($offer->status==4)
                                            {{ trans('common.Canceled') }}
                                        @endif
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.date_of_visit')}}:</td>
                                    <td> {{$offer->date_of_visit}}</td>
                                </tr>

                            </table>
                        </div>
                        {{-- <div class="col-12">
                            <a href="{{route('edit_offer', $offer->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_offer', $offer->id)}}" data-direct="{{route('offers')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->

        <!-- owner start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{trans('common.Ride')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{$offer->owner->image}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td>{{$offer->owner->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Email')}}</td>
                                    <td>{{$offer->owner->email}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Mobile')}}</td>
                                    <td>+({{$offer->owner->phone_code}}) {{$offer->owner->phone_number}}</td>
                                </tr>
                                {{-- <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td>
                                        <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                            <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$offer->id}}" id="customSwitch100" {{ $offer->status == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch100">
                                                <span class="switch-text-left">{{trans('common.Active')}}</span>
                                                <span class="switch-text-right">{{trans('common.Block')}}</span>
                                            </label>
                                        </div>
                                    </td>

                                </tr> --}}
                            </table>
                        </div>
                        {{-- <div class="col-12">
                            <a href="{{route('edit_offer', $offer->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_offer', $offer->id)}}" data-direct="{{route('offers')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- owner end -->

        <!-- user start -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{trans('common.User')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{$offer->user->image}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td>{{$offer->user->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Email')}}</td>
                                    <td>{{$offer->user->email}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Mobile')}}</td>
                                    <td>+({{$offer->user->phone_code}}) {{$offer->user->phone_number}}</td>
                                </tr>
                                {{-- <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td>
                                        <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                            <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$offer->id}}" id="customSwitch100" {{ $offer->status == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch100">
                                                <span class="switch-text-left">{{trans('common.Active')}}</span>
                                                <span class="switch-text-right">{{trans('common.Block')}}</span>
                                            </label>
                                        </div>
                                    </td>

                                </tr> --}}
                            </table>
                        </div>
                        {{-- <div class="col-12">
                            <a href="{{route('edit_offer', $offer->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_offer', $offer->id)}}" data-direct="{{route('offers')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- user end -->

    </div>
</section>
<!-- page users view end -->
@endsection

@section('script')
<script>
$(document).on('change', '.toggle-class', function() {
    var status = $(this).prop('checked') == true ? 1 : 0;
    var user_id = $(this).data('id');
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('block_offer')}}",
        data: {'status': status, 'user_id': user_id},
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
