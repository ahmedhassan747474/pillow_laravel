@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/file-uploaders/dropzone.css')}}"> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/dropzone.css')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/basic.css')}}"></script> -->
<link href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" rel="stylesheet">

@endsection
@section('page_title')
{{trans('common.edit travel agency')}}  
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
                    <h4 class="card-title">{{trans('common.edit travel agency')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('update_travel', $travel->id)}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Travel Agency Name English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Travel Agency Name English')}}" value="{{ $travel->name_en }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Travel Agency Name Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Travel Agency Name Arabic')}}" value="{{ $travel->name_ar }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Travel Agency Description English')}}</label>
                                        <div class="controls">
                                            <textarea name="description_en" rows="4" class="form-control" 
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')" 
                                            onchange="this.setCustomValidity('')" 
                                            placeholder="{{trans('common.Enter Travel Agency Description English')}}" required>{{ $travel->description_en }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Travel Agency Description Arabic')}}</label>
                                        <div class="controls">
                                            <textarea name="description_ar" rows="4" class="form-control" 
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')" 
                                            onchange="this.setCustomValidity('')"  
                                            placeholder="{{trans('common.Enter Travel Agency Description Arabic')}}">{{ $travel->description_ar }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Country')}}</label>
                                        <div class="controls">
                                            <select class="form-control country" name="country" required>
                                                <option value="" selected disabled>{{trans('common.Select Country')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{$travel->country_id == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select City')}}</label>
                                        <select class="form-control city" name="city" required>
                                            <option value="">{{trans('common.Select City')}}</option>
                                            @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$travel->city_id == $city->id ? 'selected' : ''}}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group image_product" name="image_product_drop">
                                        @foreach($travel->propertyImage as $image)
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
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_hot_deal" {{$travel->is_hot_deal == '1' ? 'checked' : ''}}>
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
                                                        <input type="checkbox" name="is_cheapest" {{$travel->is_cheapest == '1' ? 'checked' : ''}}>
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
                                                        <input type="checkbox" name="is_popular" {{$travel->is_popular == '1' ? 'checked' : ''}}>
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
                                    
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>{{trans('common.Select Book List')}}</label>
                                        <div class="controls">
                                            <select class="form-control" name="book_list" required>
                                                <option value="" selected disabled>{{trans('common.Select Book List')}}</option>
                                                @foreach($books as $book)
                                                <option value="{{$book->id}}" {{$travel->book_list_id == $book->id ? 'selected' : ''}}>{{ $book->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Traveler Date')}}</label>
                                        <div class="controls">
                                            <input type='date' name="traveler_date" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Traveler Date')}}" value="{{ date('Y-m-d', strtotime($travel->traveler_date)) }}" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Traveler Number')}}</label>
                                        <div class="controls">
                                            <input type="text" name="traveler_number" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Traveler Number')}}" value="{{ $travel->traveler_number }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Through')}}</label>
                                        <div class="controls">
                                            <select class="form-control" name="through" required>
                                                <option value="" selected disabled>{{trans('common.Select Through')}}</option>
                                                @foreach($throughs as $through)
                                                <option value="{{$through->id}}" {{$travel->through_id == $through->id ? 'selected' : ''}}>{{ $through->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Latitude')}}</label>
                                        <div class="controls">
                                            <input type="text" name="latitude" class="form-control" pattern="^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Latitude')}}" value="{{ $travel->latitude }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Longitude')}}</label>
                                        <div class="controls">
                                            <input type="text" name="longitude" class="form-control" required pattern="^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Longitude')}}" value="{{ $travel->longitude }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Price')}}</label>
                                        <div class="controls">
                                            <input type="text" name="price" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Price')}}" value="{{ $travel->price }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Discount')}}</label>
                                        <div class="controls">
                                            <input type="text" name="discount" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Discount')}}" value="{{ $travel->discount }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Discount Type')}}</label>
                                        <select class="form-control" name="discount_type">
                                            <option value="" selected disabled>{{trans('common.Select Discount Type')}}</option>
                                            <option value="percent" {{$travel->discount_type == 'percent' ? 'selected' : ''}}>{{trans('common.Percent')}}</option>
                                            <option value="price" {{$travel->discount_type == 'price' ? 'selected' : ''}}>{{trans('common.Price')}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Per')}}</label>
                                        <div class="controls">
                                            <input type="text" name="per" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Per')}}" value="{{ $travel->per }}" required>
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

    $('.format-pickatime-mine').pickatime({
        format: 'H:i'
        // show24Hours: true,
        // // startTime: '8:00 am',
        // dynamic: true,
        // dropdown: true,
        // scrollbar: true
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

            @foreach($travel->propertyImage as $image)
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