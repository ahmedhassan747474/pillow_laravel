@extends('admin.common.index')
@section('page_title')
{{trans('common.countries')}}  
@endsection
@section('content')
<!-- Basic example and Profile cards section start -->

<section id="basic-examples">

    <div class="card">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">{{trans('common.name')}}</th>
                <th scope="col">{{trans('common.Country Code')}}</th>
                <th scope="col">{{trans('common.Status')}}</th>
                <th scope="col" width="47%">action</th>
              </tr>
            </thead>
            <tbody>    
                @foreach($countries as $country)

              <tr>
                <th scope="row">              <div class="card-header mx-auto">
                    <div class="avatar avatar-xl">
                        <img class="img-fluid" src="{{$country->flag}}" alt="img placeholder">

                    </div>
                </div></th>
                <td>{{$country->name}}</td>
                <td>{{$country->code}}</td>
                <td>             <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                    <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$country->id}}" id="customSwitch{{$country->id}}" {{ $country->status == '1' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customSwitch{{$country->id}}">
                        <span class="switch-text-left">{{trans('common.Active')}}</span>
                        <span class="switch-text-right">{{trans('common.Block')}}</span>
                    </label>
                </div></td>
         
                <td>   
                    <a href="{{route('show_country', $country->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                    <a href="{{route('edit_country', $country->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                    <button data-url="{{route('delete_country', $country->id)}}" data-direct="{{route('countries')}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
                   </td>
              </tr>
              @endforeach
            </tbody>
          </table>    </div>
    
    </section>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $countries->links() }}
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
        url: "{{route('block_country')}}",
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