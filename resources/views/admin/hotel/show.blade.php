@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/app-user.css')}}">
@endsection
@section('page_title')
{{trans('common.Hotel Detail')}}  
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
                    <div class="card-title">{{trans('common.Details')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{$hotel['image']}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                            <table>

                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td class="text-center">{{$hotel['name']}}</td>
                                </tr>
                                
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Country')}}</td>
                                    <td class="text-center">{{$hotel['country_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.City')}}</td>
                                    <td class="text-center">{{$hotel['city_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Price')}}</td>
                                    <td class="text-center">{{$hotel['price']}}</td>
                                </tr>
                                @if($hotel['discount'] != null)
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Discount')}}</td>
                                    <td class="text-center">{{$hotel['discount']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Discount Type')}}</td>
                                    <td class="text-center">{{$hotel['discount_type']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Price After Discount')}}</td>
                                    <td class="text-center">{{$hotel['after_discount']}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="is_hot_deal" {{$hotel['is_hot_deal'] == '1' ? 'checked' : ''}} disabled>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{trans('common.Hot Deal')}}</span>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-success">
                                                    <input type="checkbox" name="is_cheapest" {{$hotel['is_cheapest'] == '1' ? 'checked' : ''}} disabled>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{trans('common.Cheapest')}}</span>
                                                </div>
                                            </fieldset>
                                        </li>
                                        <li class="d-inline-block mr-2">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-danger">
                                                    <input type="checkbox" name="is_popular" {{$hotel['is_popular'] == '1' ? 'checked' : ''}} disabled>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{trans('common.Popular')}}</span>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Description')}}</td>
                                    <td class="text-center">{{$hotel['description']}}</td>
                                </tr>
                                
                            </table>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <table class="ml-0 ml-sm-0 ml-lg-0">
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Size')}}</td>
                                    <td class="text-center">{{$hotel['size']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Per')}}</td>
                                    <td class="text-center">{{$hotel['per']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Start Date')}}</td>
                                    <td class="text-center">{{$hotel['start_date']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.End Date')}}</td>
                                    <td class="text-center">{{$hotel['end_date']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Number of Adult')}}</td>
                                    <td class="text-center">{{$hotel['num_of_adult']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Number of Child')}}</td>
                                    <td class="text-center">{{$hotel['num_of_child']}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td class="text-center">
                                        <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                            <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$hotel['id']}}" id="customSwitch100" {{ $hotel['status'] == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch100">
                                                <span class="switch-text-left">{{trans('common.Active')}}</span>
                                                <span class="switch-text-right">{{trans('common.Block')}}</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Attributes')}}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach($attributes as $attribute)
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="attributes[{{$attribute->id}}]" {{checkAttribute($hotel['attributes'], $attribute->id, 'show')}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{$attribute->name}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <a href="{{route('hotel_room', $hotel['id'])}}" class="btn btn-success mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Rooms')}}</a>
                            <a href="{{route('edit_hotel', $hotel['id'])}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_hotel', $hotel['id'])}}" data-direct="{{route('hotels')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->
        <!-- Images start -->
        <div class="col-md-6 col-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-2">{{trans('common.images')}}</div>
                </div>
                <div class="card-body">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{$hotel['images'][0]['name']}}" class="img-fluid d-block w-100" alt="cf-img-1" style="height: 400px;">
                            </div>
                            @foreach($hotel['images']->skip(1) as $image)
                            <div class="carousel-item">
                                <img src="{{$image->name}}" class="img-fluid d-block w-100 h-400" alt="cf-img-1" style="height: 400px;">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Images start -->
        <!-- Map start -->
        <div class="col-md-6 col-12 ">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-2">{{trans('common.Map')}}</div>
                </div>
                <div class="card-body">
                    <iframe width="100%" height="400" src="https://maps.google.com/maps?q={{$hotel['latitude']}},{{$hotel['longitude']}}&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
        <!-- Map start -->
    </div>
</section>
<!-- page users view end -->
@endsection

@section('script')
<script>
$(document).on('change', '.toggle-class', function() {
    var status = $(this).prop('checked') == true ? 1 : 0; 
    var id = $(this).data('id'); 
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('block_property')}}",
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