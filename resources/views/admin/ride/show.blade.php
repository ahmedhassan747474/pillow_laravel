@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/app-user.css')}}">
@endsection
@section('page_title')
{{trans('common.ride detail')}}  
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
                    <div class="card-title">{{trans('common.Account')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{$ride->image}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td>{{$ride->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Email')}}</td>
                                    <td>{{$ride->email}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Mobile')}}</td>
                                    <td>+({{$ride->phone_code}}) {{$ride->phone_number}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td>
                                        <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                            <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$ride->id}}" id="customSwitch100" {{ $ride->status == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch100">
                                                <span class="switch-text-left">{{trans('common.Active')}}</span>
                                                <span class="switch-text-right">{{trans('common.Block')}}</span>
                                            </label>
                                        </div>
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <a href="{{route('edit_ride', $ride->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_ride', $ride->id)}}" data-direct="{{route('rides')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->
    </div>
</section>
<section id="basic-examples">

        @foreach($apartments as $apartment)
        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <img class="card-img img-fluid mb-1" src="{{$apartment['image']}}" alt="Card image cap" style="height: 260px;">
                        <h5 class="my-1">{{$apartment['name']}}</h5>
                        <p class="card-text  mb-0">{{$apartment['city_name']}}, {{$apartment['country_name']}}</p>
                        <span class="card-text">$ {{$apartment['price']}}</span>
                        <hr class="my-1">
                        <div class="card-btns d-flex justify-content-between">
                            <a href="{{route('show_apartment', $apartment['id'])}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                            <a href="{{route('edit_apartment', $apartment['id'])}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_apartment', $apartment['id'])}}" data-direct="{{route('apartments',$apartment['type'])}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Cards Ends -->
        @endforeach
    </div>
</section>
{{-- 
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $data->links() }}
    </ul>
</nav> --}}
<!-- page users view end -->
@endsection

@section('script')
<script>

$(document).ready(function () {
  $("#select-opt").change(function() {
    var $option = $(this).find(':selected');
    var url = $option.val();
    if (url != "") {

        window.location.href = url;
    //   url += "?text=" + encodeURIComponent($option.text());
      // Show URL rather than redirect
    //   $("#output").text(url);
    }
  });
});

$(document).on('change', '.toggle-class', function() {
    var status = $(this).prop('checked') == true ? 1 : 0; 
    var user_id = $(this).data('id'); 
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('block_ride')}}",
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