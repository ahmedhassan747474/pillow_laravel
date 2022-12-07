@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/file-uploaders/dropzone.css')}}"> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/dropzone.css')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/basic.css')}}"></script> -->
<link href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" rel="stylesheet">

@endsection
@section('page_title')
{{trans('common.edit room')}}  
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
                    <h4 class="card-title">{{trans('common.edit room')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('update_hotel_room', $room->id)}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Name English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Room Name English')}}" value="{{ $room->name_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Room Name Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Room Name Arabic')}}" value="{{ $room->name_ar }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Refundable English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="refund_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Refundable English')}}" value="{{ $room->refund_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Refundable Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="refund_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Refundable Arabic')}}" value="{{ $room->refund_ar }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Payment Receipt English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="payment_receipt_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Payment Receipt English')}}" value="{{ $room->payment_receipt_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Payment Receipt Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="payment_receipt_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Payment Receipt Arabic')}}" value="{{ $room->payment_receipt_ar }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Include English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="include_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Include English')}}" value="{{ $room->include_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Include Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="include_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Include Arabic')}}" value="{{ $room->include_ar }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group image_product" name="image_product_drop">
                                        @foreach($room->propertyImage as $image)
                                        <input type="hidden" name="images[]" id="images_hidden_{{$image->id}}" value="{{$image->only_name}}">
                                        @endforeach
                                        <label>{{trans('common.Upload Photo')}}</label>
                                        <div class="dropzone dropzone-default dropzone-primary" id="kt_dropzone_5">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">{{trans('common.Upload Photo')}}</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Attributes')}}</label>
                                        <ul class="list-unstyled mb-0 mt-2">
                                            @foreach($attributes as $attribute)
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="attributes[{{$attribute->id}}]" {{checkAttribute($room->propertyAttribute, $attribute->id, 'edit')}}>
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
                                        <label>{{trans('common.Enter Number of Adult')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_adult" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Adult')}}" value="{{ $room->num_of_adult }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Child')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_child" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Child')}}" value="{{ $room->num_of_child }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Bed')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_bed" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Bed')}}" value="{{ $room->num_of_bed }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Price')}}</label>
                                        <div class="controls">
                                            <input type="text" name="price" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Price')}}" value="{{ $room->price }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Discount')}}</label>
                                        <div class="controls">
                                            <input type="text" name="discount" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Discount')}}" value="{{ $room->discount }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Discount Type')}}</label>
                                        <select class="form-control" name="discount_type">
                                            <option value="" selected disabled>{{trans('common.Select Discount Type')}}</option>
                                            <option value="percent" {{$room->discount_type == 'percent' ? 'selected' : ''}}>{{trans('common.Percent')}}</option>
                                            <option value="price" {{$room->discount_type == 'price' ? 'selected' : ''}}>{{trans('common.Price')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Size')}}</label>
                                        <div class="controls">
                                            <input type="text" name="size" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Size')}}" value="{{ $room->size }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Per')}}</label>
                                        <div class="controls">
                                            <input type="text" name="per" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Per')}}" value="{{ $room->per }}" required>
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

<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/dropzone.js')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/dropzonejs.js?v=7.0.4')}}"></script> -->

<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

<script>
    $('.format-picker-mine').pickadate({
        format: 'yyyy-mm-dd',
        // keepOpen: false,
        // inline: false,
        // sideBySide: false,
    });

    $('#kt_dropzone_5').dropzone({
        url: "{{route('image_property')}}", // Set the url for your upload script location
        paramName: "image", // The name that will be used to transfer the file
        maxFiles: 5,
        maxFilesize: 1000, // MB
        acceptedFiles: 'image/jpeg,image/png,image/gif,image/jpg',
        addRemoveLinks: true,
        timeout: 3600000,
        dictRemoveFile: "{{trans('common.Delete Image')}}",
        dictRemoveFileConfirmation: "{{trans('common.Are you sure to delete the image?')}}",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        removedfile: function(file) {
            // var fileName = file.upload.uuid;
            var fileName = '';
            if (file.upload == null) {
                fileName = file.uuid;
            } else {
                fileName = file.upload.uuid;
            }  
            // console.log("#"+fileName);
            // console.log($("#"+fileName));
            $("#"+fileName).remove();
            // product_images_length = product_images_length - 3;
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        init: function () {
            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file);
            });

            @foreach($room->propertyImage as $image)
                var mockFile = { name: "{{$image->only_name}}", size: 12345 , uuid: "images_hidden_{{$image->id}}", accepted: true};
                this.files.push(mockFile);
                this.displayExistingFile(mockFile, '{{$image->name}}');
            @endforeach

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