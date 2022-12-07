@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
@endsection
@section('page_title')
{{trans('common.edit country')}}  
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
                    <h4 class="card-title">{{trans('common.edit country')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('update_country', $country->id)}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                {{-- <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Name English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_en" class="form-control" pattern="^[a-zA-Z\s]+$" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Name English')}}" value="{{ $country->name_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class="media-object rounded-circle" src="{{ $country->flag }}" alt="Generic placeholder image" height="64" width="64">
                                            </div>

                                            <div class="col-md-9">
                                                <label for="basicInputFile">{{trans('common.Upload Flag')}}</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="flag">
                                                    <label class="custom-file-label" for="inputGroupFile01">{{trans('common.Choose file')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div> --}}

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Name Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Name Arabic')}}" value="{{ $country->name_ar }}" required>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Country Code')}}</label>
                                        <div class="controls">
                                            <input type="text" name="code" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Country Code')}}" value="{{ $country->code }}" required>
                                        </div>
                                    </div> --}}

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