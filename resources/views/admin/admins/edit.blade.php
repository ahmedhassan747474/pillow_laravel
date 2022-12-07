@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
@endsection
@section('page_title')
{{trans('common.edit admin')}}  
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
                    <h4 class="card-title">{{trans('common.edit admin')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate action="{{route('update_admin', $admin->id)}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Name')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name" class="form-control" data-validation-containsnumber-regex="^[a-zA-Z\s]+$" data-validation-required-message="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Name')}}" value="{{ $admin->name }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Permission')}}</label>
                                        <select class="form-control" name="permission" data-validation-required-message="{{trans('common.This field is required')}}" required>
                                            @foreach($permissions as $permission)
                                            <option value="{{$permission->id}}" {{$admin->adminPermission->permission_id == $permission->id ? 'selected' : ''}}>{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Email')}}</label>
                                        <div class="controls">
                                            <input type="email" name="email" class="form-control" data-validation-required-message="{{trans('common.Must be a valid email')}}" placeholder="{{trans('common.Enter Email')}}" value="{{ $admin->email }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="can_show" {{$admin->adminPermission->can_show == 1 ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Show')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="can_create" {{$admin->adminPermission->can_create == 1 ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Create')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-warning">
                                                        <input type="checkbox" name="can_edit" {{$admin->adminPermission->can_edit == 1 ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Edit')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="can_delete" {{$admin->adminPermission->can_delete == 1 ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Delete')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">

                                    <div class="media">
                                        <a href="javascript: void(0);">
                                            <img src="{{$admin->image}}" class="rounded mr-75" alt="profile image" height="64" width="64">
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
                                        <label>{{trans('common.Password Input Field')}}</label>
                                        <div class="controls">
                                            <input type="password" name="password" class="form-control" placeholder="{{trans('common.Password')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Repeat password must match')}}</label>
                                        <div class="controls">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{trans('common.Repeat Password')}}">
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