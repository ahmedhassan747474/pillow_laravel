@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<link href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" rel="stylesheet">
@endsection
@section('page_title')
{{trans('common.create room')}}
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
                    <h4 class="card-title">{{trans('common.create room')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('store_room')}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Name English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Room Name English')}}" value="{{ old('name_en') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Name Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Room Name Arabic')}}" value="{{ old('name_ar') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Description English')}}</label>
                                        <div class="controls">
                                            <textarea name="description_en" rows="4" class="form-control" 
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')" 
                                            onchange="this.setCustomValidity('')" 
                                            placeholder="{{trans('common.Enter Room Description English')}}" required>{{ old('description_en') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Description Arabic')}}</label>
                                        <div class="controls">
                                            <textarea name="description_ar" rows="4" class="form-control" 
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')" 
                                            onchange="this.setCustomValidity('')"  
                                            placeholder="{{trans('common.Enter Room Description Arabic')}}">{{ old('description_ar') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Country')}}</label>
                                        <div class="controls">
                                            <select class="form-control country" name="country" required>
                                                <option value="" selected disabled>{{trans('common.Select Country')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{old('country') == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select City')}}</label>
                                        <select class="form-control city" name="city" required>
                                            <option value="">{{trans('common.Select City')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group image_product" name="image_product_drop">
                                        <label>{{trans('common.Upload Photo')}}</label>
                                        <div class="dropzone dropzone-default dropzone-primary" id="kt_dropzone_5">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">{{trans('common.Upload Photo')}}</h3>
                                            </div>
                                        </div>
                                        <!-- <div class="media">
                                            <div class="media-body mt-75">
                                                <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                    <input type="file" name="images[]" multiple class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" required>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="form-group">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_hot_deal" {{old('is_hot_deal') == 'on' ? 'checked' : ''}}>
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
                                                        <input type="checkbox" name="is_cheapest" {{old('is_cheapest') == 'on' ? 'checked' : ''}}>
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
                                                        <input type="checkbox" name="is_popular" {{old('is_popular') == 'on' ? 'checked' : ''}}>
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
                                    </div>

                                    <hr class="my-1">

                                    <div class="form-group">
                                        <label>{{trans('common.Attributes')}}</label>
                                        <ul class="list-unstyled mb-0 mt-2">
                                            @foreach($attributes as $attribute)
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="attributes[{{$attribute->id}}]" {{old('attribute.$attribute->id') == 'on' ? 'checked' : ''}}>
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
                                    </div>

                                    <hr class="my-1">

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Start Date')}}</label>
                                        <div class="controls">
                                            <input type='text' name="start_date" class="form-control format-picker-mine" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Start Date')}}" value="{{ old('start_date') }}" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter End Date')}}</label>
                                        <div class="controls">
                                            <input type='text' name="end_date" class="form-control format-picker-mine" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter End Date')}}" value="{{ old('end_date') }}" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Adult')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_adult" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Adult')}}" value="{{ old('num_of_adult') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Child')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_child" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Child')}}" value="{{ old('num_of_child') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Latitude')}}</label>
                                        <div class="controls">
                                            <input type="text" name="latitude" class="form-control" pattern="^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Latitude')}}" value="{{ old('latitude') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Longitude')}}</label>
                                        <div class="controls">
                                            <input type="text" name="longitude" class="form-control" required pattern="^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Longitude')}}" value="{{ old('longitude') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Price')}}</label>
                                        <div class="controls">
                                            <input type="text" name="price" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Price')}}" value="{{ old('price') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Discount')}}</label>
                                        <div class="controls">
                                            <input type="text" name="discount" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Discount')}}" value="{{ old('discount') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Discount Type')}}</label>
                                        <select class="form-control" name="discount_type">
                                            <option value="" selected disabled>{{trans('common.Select Discount Type')}}</option>
                                            <option value="percent" {{old('discount_type') == 'percent' ? 'selected' : ''}}>{{trans('common.Percent')}}</option>
                                            <option value="price" {{old('discount_type') == 'price' ? 'selected' : ''}}>{{trans('common.Price')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Size')}}</label>
                                        <div class="controls">
                                            <input type="text" name="size" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Size')}}" value="{{ old('size') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Per')}}</label>
                                        <div class="controls">
                                            <input type="text" name="per" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Per')}}" value="{{ old('per') }}" required>
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

<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>

<script src="{{asset('/admin_asset/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>

<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

<script>
    $('.format-picker-mine').pickadate({
        format: 'yyyy-mm-dd'
    });

    // multiple file upload (Image products)
    $('#kt_dropzone_5').dropzone({
        url: "{{route('image_property')}}", // Set the url for your upload script location
        paramName: "image", // The name that will be used to transfer the file
        // maxFiles: 10,
        maxFilesize: 1000, // MB
        acceptedFiles: 'image/jpeg,image/png,image/gif,image/jpg',
        addRemoveLinks: true,
        timeout: 3600000,
        dictRemoveFile: 'مسح الصورة',
        dictRemoveFileConfirmation: "هل انت متأكد من حذف الصوره ؟",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        removedfile: function(file) {
            var fileName = file.upload.uuid;
            // console.log("#"+fileName);
            // console.log($("#"+fileName));
            $("#"+fileName).remove();
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        init: function () {
            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file);
            });
            this.on("success", function (file, done) {
                if (file.status == "success") {
                    $('.image_product').append('<input type="hidden" name="images[]" id="' + file.upload.uuid + '" value="' + done.data + '">')
                }
                // console.log(done);
            });
            
            this.on("error", function(file) {
                this.removeFile(file);
            });
        },
        accept: function(file, done) {
            // console.log(file);
            console.log(done);
            if (file.status == "success") {
                done();
            } else {
                done();
            }
        }
    });
</script>
@endsection