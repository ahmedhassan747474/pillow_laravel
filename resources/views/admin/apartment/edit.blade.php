@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<!-- <link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/file-uploaders/dropzone.css')}}"> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/dropzone.css')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/basic.css')}}"></script> -->
<link href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" rel="stylesheet">
<style>
   body,
html,
#map_canvas {
  height: 17em;
  margin: 0;
}

#map_canvas .centerMarker {
  position: absolute;
  /*url of the marker*/
  background: url(http://maps.gstatic.com/mapfiles/markers2/marker.png) no-repeat;
  /*center the marker*/
  top: 35%;
  left: 50%;
  z-index: 1;
  /*fix offset when needed*/
  margin-left: -10px;
  margin-top: -34px;
  /*size of the image*/
  height: 34px;
  width: 20px;
  cursor: pointer;
}

    </style>
@endsection
@section('page_title')
{{trans('common.edit apartment')}}
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
                    <h4 class="card-title">{{trans('common.edit apartment')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('update_apartment', $apartment->id)}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                <div class="col-md-6">

                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Apartment Name English')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_en" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Apartment Name English')}}" value="{{ $apartment->name_en }}" required>
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Apartment Name Arabic')}}</label>
                                        <div class="controls">
                                            <input type="text" name="name_ar" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Apartment Name Arabic')}}" value="{{ $apartment->name_ar }}" required>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Apartment Description English')}}</label>
                                        <div class="controls">
                                            <textarea name="description_en" rows="4" class="form-control"
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')"
                                            onchange="this.setCustomValidity('')"
                                            placeholder="{{trans('common.Enter Apartment Description English')}}" required>{{ $apartment->description_en }}</textarea>
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Apartment Description Arabic')}}</label>
                                        <div class="controls">
                                            <textarea name="description_ar" rows="4" class="form-control"
                                            oninvalid="this.setCustomValidity('{{trans('common.This field is required')}}')"
                                            onchange="this.setCustomValidity('')"
                                            placeholder="{{trans('common.Enter Apartment Description Arabic')}}">{{ $apartment->description_ar }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Payment Method')}}</label>
                                        <div class="controls">
                                            <input type="text" value="{{ $apartment->payment_method }}" name="payment_methods" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Payment Method')}}" value="{{ old('payment_method') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Type')}}</label>
                                        <select class="form-control" name="type" required>
                                            <option value="">{{trans('common.Select Type')}}</option>
                                            @foreach (\App\PropertyList::whereStatus('1')->orderBy('name_ar', 'asc')->get() as $index=>$item)
                                                <option {{ $item->id == $apartment->type?'selected':'' }} value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Country')}}</label>
                                        <div class="controls">
                                            <select class="form-control country" name="country" required>
                                                <option value="" selected disabled>{{trans('common.Select Country')}}</option>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" {{$apartment->country_id == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select City')}}</label>
                                        <select class="form-control city" name="city" required>
                                            <option value="">{{trans('common.Select City')}}</option>
                                            @foreach($cities as $city)
                                            <option value="{{$city->id}}" {{$apartment->city_id == $city->id ? 'selected' : ''}}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group image_product" name="image_product_drop">
                                        @foreach($apartment->propertyImage as $image)
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
                                            {{-- <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="is_hot_deal" {{$apartment->is_hot_deal == '1' ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Hot Deal')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li> --}}
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-success">
                                                        <input type="checkbox" name="is_furnished" {{$apartment->is_furnished == '1' ? 'checked' : ''}}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">{{trans('common.Furnished')}}</span>
                                                    </div>
                                                </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-2">
                                                <fieldset>
                                                    <div class="vs-checkbox-con vs-checkbox-danger">
                                                        <input type="checkbox" name="is_popular" {{$apartment->is_popular == '1' ? 'checked' : ''}}>
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
                                                        <input type="checkbox" name="attributes[{{$attribute->id}}]" {{checkAttribute($apartment->propertyAttribute, $attribute->id, 'edit')}}>
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

                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Start Date')}}</label>
                                        <div class="controls">
                                            <input type='date' name="start_date" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Start Date')}}" value="{{ date('Y-m-d', strtotime($apartment->start_date)) }}" required />
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>{{trans('common.Enter End Date')}}</label>
                                        <div class="controls">
                                            <input type='date' name="due_date" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter End Date')}}" value="{{ date('Y-m-d', strtotime($apartment->due_date)) }}" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Rooms')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_rooms" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Rooms')}}" value="{{ $apartment->num_of_rooms }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Number of Baths')}}</label>
                                        <div class="controls">
                                            <input type="text" name="num_of_baths" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Number of Baths')}}" value="{{ $apartment->num_of_baths }}">
                                        </div>
                                    </div>

                                 <div class="form-group">
                                        <label>{{trans('common.Enter Latitude')}}</label>
                                        <div class="controls">
                                            <input type="text" id="default_latitude" name="latitude" class="form-control" pattern="^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Latitude')}}" value="{{ $apartment->latitude }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Longitude')}}</label>
                                        <div class="controls">
                                            <input type="text" id="default_longitude" name="longitude" class="form-control" required pattern="^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Longitude')}}" value="{{ $apartment->longitude }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Price')}}</label>
                                        <div class="controls">
                                            <input type="text" name="price" class="form-control" required pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Price')}}" value="{{ $apartment->price }}" required>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Discount')}}</label>
                                        <div class="controls">
                                            <input type="text" name="discount" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Discount')}}" value="{{ $apartment->discount }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{trans('common.Select Discount Type')}}</label>
                                        <select class="form-control" name="discount_type">
                                            <option value="" selected disabled>{{trans('common.Select Discount Type')}}</option>
                                            <option value="percent" {{$apartment->discount_type == 'percent' ? 'selected' : ''}}>{{trans('common.Percent')}}</option>
                                            <option value="price" {{$apartment->discount_type == 'price' ? 'selected' : ''}}>{{trans('common.Price')}}</option>
                                        </select>
                                    </div> --}}

                                    <div class="form-group">
                                        <label>{{trans('common.Enter Size')}}</label>
                                        <div class="controls">
                                            <input type="text" name="size" class="form-control" pattern="(\d)+" data-error="{{trans('common.The numeric field may only contain numeric characters.')}}" placeholder="{{trans('common.Enter Size')}}" value="{{ $apartment->size }}" required>
                                        </div>
                                    </div>
                                    <label>{{ __('Drag Your Address') }}</label>
                                    <div id="map_canvas" class="map-canvas"></div>
                                    <input type="hidden" id="default_latitude" placeholder="Latitude"/>
                                    <input type="hidden" id="default_longitude" placeholder="Longitude"/>
                                    <div id="map_canvas" ></div>
                                    {{-- <div class="form-group">
                                        <label>{{trans('common.Enter Per')}}</label>
                                        <div class="controls">
                                            <input type="text" name="per" class="form-control" data-error="{{trans('common.This field is required')}}" placeholder="{{trans('common.Enter Per')}}" value="{{ $apartment->per }}" required>
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

<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>

<script src="{{asset('/admin_asset/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/dropzone/dropzone.js')}}"></script> -->
<!-- <script src="{{asset('/admin_asset/app-assets/vendors/js/extensions/dropzonejs.js?v=7.0.4')}}"></script> -->

<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&callback=initialize"></script>

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

            @foreach($apartment->propertyImage as $image)
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
<script>
function initialize() {
  var mapOptions = {
    zoom: 12,
    center: new google.maps.LatLng(30.054995683135303, 31.202324918842923),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map_canvas'),
    mapOptions);
  google.maps.event.addListener(map,'center_changed', function() {
    document.getElementById('default_latitude').value = map.getCenter().lat();
    document.getElementById('default_longitude').value = map.getCenter().lng();
  });
  $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
    //do something onclick
    .click(function() {
      var that = $(this);
      if (!that.data('win')) {
        that.data('win', new google.maps.InfoWindow({
          content: 'this is the center'
        }));
        that.data('win').bindTo('position', map, 'center');
      }
      that.data('win').open(map);
    });
}

// google.maps.event.addDomListener(window, 'load', initialize);

</script>
@endsection
