@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/plugins/forms/validation/form-validation.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('/vendor/summernote/summernote-bs4.min.css') }}" rel="stylesheet">

<style>
     textarea{
            margin-bottom: 15px !important;
            position: relative !important;
        }
        .nicEdit-pane{
            position: fixed;
            top: 1px;
        }
</style>
@endsection
@section('page_title')
{{trans('common.edit information')}}
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
                    <h4 class="card-title">{{trans('common.edit information')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" validate action="{{route('update_information')}}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="basicInputFile">{{trans('common.Upload Photo')}}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="image" data-error="{{trans('common.This field is required')}}" required>
                                            <label class="custom-file-label" for="inputGroupFile01">{{trans('common.Choose file')}}</label>
                                        </div>
                                    </div>
                                </div> --}}



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('common.Terms')}}</label>
                                        <div class="controls">
                                            <textarea name="terms" class="form-control summernote ckeditor"  data-error="{{trans('common.This field is required')}}"  id="summernote" required rows="10">
                                                {{ $information->terms??'' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('common.Conditions')}}</label>
                                        <div class="controls">
                                            <textarea name="conditions" class="form-control summernote ckeditor"  data-error="{{trans('common.This field is required')}}"  id="summernote" required rows="10">
                                                {{ $information->conditions??'' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('common.About')}}</label>
                                        <div class="controls">
                                            <textarea name="about" class="form-control summernote ckeditor"  data-error="{{trans('common.This field is required')}}"  id="summernote" required rows="10">
                                                {{ $information->about??'' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('common.Contact')}}</label>
                                        <div class="controls">
                                            <input type="text" name="contact" class="form-control" value="{{ $information->contact??'' }}">

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
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

{{-- <!-- CKEditor App --> --}}
{{-- <script src="{{ asset('admin_asset/ckeditor/ckeditor.js') }}"></script> --}}
<script>
    $(document).ready(function() {

        // CKEDITOR.config.language = "ar";
        // CKEDITOR.config.language = "{{ app()->getLocale() }}";
    });
</script>
<script src="{{asset('/admin_asset/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{ asset('/vendor/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
        $('.summernote').summernote({
            tabSize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
