@extends('admin.common.index')
@section('page_title')
{{trans('common.attributes')}}  
@endsection
@section('content')
<!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <div class="row match-height">

        <section id="basic-examples">

            <div class="card">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">phone_number</th>
                        <th scope="col">phone_number</th>
                        <th scope="col" width="47%">action</th>
                      </tr>
                    </thead>
                    <tbody>    
                        @foreach($attributes as $attribute)
                      <tr>
                        <th scope="row">                <div class="card-header mx-auto">
                            <div class="avatar avatar-xl">
                                <img class="img-fluid" src="{{$attribute->image}}" alt="img placeholder">
                            </div>
                        </div>
                    </th>
                        <td>{{$attribute->name}}</td>
                        <td>{{trans('common.Status')}}</td>
                        <td>        <div class="col-md-6">
                            <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                                <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$attribute->id}}" id="customSwitch{{$attribute->id}}" {{ $attribute->status == '1' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customSwitch{{$attribute->id}}">
                                    <span class="switch-text-left">{{trans('common.Active')}}</span>
                                    <span class="switch-text-right">{{trans('common.Block')}}</span>
                                </label>
                            </div>
                        </div></td>
                 
                        <td>   
                            <div class="card-btns d-flex justify-content-between">
                                <!-- <a href="{{route('show_attribute', $attribute->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a> -->
                                <a href="{{route('attribute_value', $attribute->id)}}" class="btn btn-primary">{{trans('common.Values')}}</a>
                                <a href="{{route('edit_attribute', $attribute->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                                <button data-url="{{route('delete_attribute', $attribute->id)}}" data-direct="{{route('attributes')}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
                            </div>
                              </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>    </div>
            
            </section>

        <!-- Profile Cards Starts -->
        {{-- <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
            <div class="card">
          
                <div class="card-content">
                    <div class="card-body text-center">
                        <h4></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5></h5>
                            </div>
                    
                        </div>

                        <hr class="my-1">
                                
                
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Profile Cards Ends -->
        {{-- @endforeach --}}
    </div>
</section>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $attributes->links() }}
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
        url: "{{route('block_attribute')}}",
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

$(document).on('click', '.delete-ajax', function() {
    var url = $(this).data('url');
    var direct = $(this).data('direct');
    Swal.fire({
        title: "{{trans('common.Are you sure?')}}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{trans('common.Yes, delete it')}}"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                success: function(data){
                    Swal.fire({
                        icon: 'success',
                        title: "{{trans('common.Deleted Successfully')}}",
                        showConfirmButton: false
                    })
                    setTimeout(function () {
                        window.location.href = direct;
                    }, 2000);
                }
            });
        }
    })
})

</script>
@endsection