@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/app-user.css')}}">
@endsection
@section('page_title')
{{trans('common.permission detail')}}  
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
                    <div class="card-title">{{trans('common.permission detail')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td>{{$permission->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Pages')}}</td>
                                    <td>
                                        
                                        <ul class="list-unstyled mb-0">

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_admin" {{$permission->is_admin == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Admin')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_user" {{$permission->is_user == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.User')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_ride" {{$permission->is_ride == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Ride')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_hotel" {{$permission->is_hotel == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Hotel')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_furnished" {{$permission->is_furnished == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Furnished Apartment')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_shared" {{$permission->is_shared == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Shared Room')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_restaurant" {{$permission->is_restaurant == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Restaurant')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_wedding" {{$permission->is_wedding == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Wedding Hall')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_travel" {{$permission->is_travel == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Travel Agency')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_business" {{$permission->is_business == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Business Space')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_car" {{$permission->is_car == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Car')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_residential" {{$permission->is_residential == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Residential')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_attributes" {{$permission->is_attributes == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Attributes')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_book_list" {{$permission->is_book_list == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Book List')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_through" {{$permission->is_through == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Through')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_include" {{$permission->is_include == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Include')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_residential_type" {{$permission->is_residential_type == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Residential Type')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_country" {{$permission->is_country == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Country')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_city" {{$permission->is_city == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.City')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_reason" {{$permission->is_reason == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Reason')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_coupon" {{$permission->is_coupon == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Coupon')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_property" {{$permission->is_property == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Property')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="is_reservation" {{$permission->is_reservation == 1 ? 'checked' : ''}} disabled>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Reservation')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>

                                        </ul>
                                        
                                    </td>
                                    
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <a href="{{route('edit_permission', $permission->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_permission', $permission->id)}}" data-direct="{{route('permissions')}}" class="btn btn-danger delete-ajax"><i class="feather icon-trash-2"></i> {{trans('common.Delete')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- account end -->
    </div>
</section>
<!-- page users view end -->
@endsection

@section('script')
<script>

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