@extends('admin.common.index')
@section('page_title')
{{trans('common.properties')}}
@endsection
@section('content')
<!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <div class="row match-height">
        @foreach($properties as $property)
        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
            <div class="card">
                <div class="card-header mx-auto">
                    <div class="avatar avatar-xl">
                        <img class="img-fluid" src="{{$property->image}}" alt="img placeholder">
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body text-center">

                        <h4>{{$property->name}}</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{trans('common.Status')}}</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                    <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$property->id}}" id="customSwitch{{$property->id}}" {{ $property->status == '1' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customSwitch{{$property->id}}">
                                        <span class="switch-text-left">{{trans('common.Active')}}</span>
                                        <span class="switch-text-right">{{trans('common.Block')}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-1">

                        <div class="card-btns d-flex justify-content-between">
                            <a href="{{route('show_property', $property->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                            <a href="{{route('delete_property', $property->id)}}" class="btn btn-danger">{{trans('common.Delete')}}</a>
                            <a href="{{route('edit_property', $property->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Cards Ends -->
        @endforeach
    </div>
</section>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $properties->links() }}
    </ul>
</nav>
<!-- // Basic example and Profile cards section end -->
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
