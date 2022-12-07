@extends('admin.common.index')
@section('page_title')
{{trans('common.permissions')}}  
@endsection
@section('content')

<a href="{{route('add_permission')}}" class="btn btn-outline-primary mb-2"><i class="feather icon-plus"></i>{{trans('common.Add')}}</a>

<!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <div class="row match-height">
        @foreach($permissions as $permission)
        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">

                        <h4>{{$permission->name}}</h4>

                        <hr class="my-1">
                                
                        <div class="card-btns d-flex justify-content-between">
                            <a href="{{route('show_permission', $permission->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                            <a href="{{route('edit_permission', $permission->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_permission', $permission->id)}}" data-direct="{{route('permissions')}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
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
        {{ $permissions->links() }}
    </ul>
</nav>
<!-- // Basic example and Profile cards section end -->
@endsection

@section('script')
<script>

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