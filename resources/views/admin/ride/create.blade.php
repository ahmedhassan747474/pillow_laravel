@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
@endsection
@section('page_title')
{{trans('common.create ride')}}
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

<!-- Input Validation start -->
<section class="input-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{trans('common.create ride')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate action="{{route('store_ride')}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Name')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name" class="form-control" data-validation-containsnumber-regex="^[a-zA-Z\s]+$" data-validation-required-message="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Name')}}" value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Country')}}</label>
                                        <select class="form-control" name="country" data-validation-required-message="{{trans('common.This field is required')}}" required>
                                            @foreach($countries as $country)
                                            <option value="{{$country->code}}" {{old('country') == $country->code ? 'selected' : ''}}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Phone Number')}}</label>
                                        <div class="controls">
                                            <input type="text" name="phone" class="form-control" required data-validation-containsnumber-regex="(\d)+" data-validation-containsnumber-message="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Phone Number')}}" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">

                                    <div class="media">
                                        <a href="javascript: void(0);">
                                            <img src="{{asset('/admin_asset/app-assets/images/portrait/small/avatar-s-12.jpg')}}" class="rounded mr-75" alt="profile image" height="64" width="64">
                                        </a>
                                        <div class="media-body mt-75">
                                            <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                <!-- <label>{{trans('common.Upload Photo')}}</label> -->
                                                <input type="file" name="image" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer">
                                            </div>
                                            <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max
                                                    size of
                                                    2 MB</small></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Email')}}</label>
                                        <div class="controls">
                                            <input type="email" name="email" class="form-control" data-validation-required-message="{{trans('common.Must be a valid email')}}" placeholder="{{trans('common.Enter Email')}}" value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Password Input Field')}}</label>
                                        <div class="controls">
                                            <input type="password" name="password" class="form-control" data-validation-required-message="{{trans('common.This field is required')}}" placeholder="{{trans('common.Password')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Repeat password must match')}}</label>
                                        <div class="controls">
                                            <input type="password" name="password_confirmation" data-validation-match-match="password" class="form-control" data-validation-required-message="{{trans('common.Repeat password must match')}}" placeholder="{{trans('common.Repeat Password')}}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{trans('common.Submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Input Validation end -->
@endsection

@section('script')
<script src="{{asset('/admin_asset/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
@endsection