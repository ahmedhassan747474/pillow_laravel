@extends('admin.common.index')
@section('page_title')
{{trans('common.rides')}}  
@endsection
@section('content')
<br>
<input class="form-control" id="myInput" type="text" placeholder="Search..">
<br>
<section id="basic-examples">
<div class="card">

<table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">phone_number</th>
        <th scope="col" width="47%">action</th>
      </tr>
    </thead>
    <tbody id="myTable">
            @foreach($rides as $ride)
      <tr>
        <th scope="row">1</th>
        <td>{{$ride->name}}</td>
        <td>{{$ride->phone_number}}</td>
 
        <td>   
            <a href="{{route('show_ride', $ride->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a>
            <a href="{{route('edit_ride', $ride->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
            <button data-url="{{route('delete_ride', $ride->id)}}" data-direct="{{route('rides')}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>    </div>
</section>
<!-- Basic example and Profile cards section start -->


<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $rides->links() }}
    </ul>
</nav>
<!-- // Basic example and Profile cards section end -->
@endsection

@section('script')
<script>
        $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
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