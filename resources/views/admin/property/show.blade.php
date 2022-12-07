@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/app-user.css')}}">
@endsection
@section('page_title')
{{trans('common.property detail')}}  
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
                    <div class="card-title">{{trans('common.Property Detail')}}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="users-view-image">
                            <img src="{{$property->image}}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                        </div>
                        <div class="col-12">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Name')}}</td>
                                    <td>{{$property->name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{trans('common.Status')}}</td>
                                    <td>
                                        <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                            <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$property->id}}" id="customSwitch100" {{ $property->status == '1' ? 'checked' : '' }}>
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
                            <a href="{{route('edit_property', $property->id)}}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> {{trans('common.Edit')}}</a>
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
</script>
@endsection