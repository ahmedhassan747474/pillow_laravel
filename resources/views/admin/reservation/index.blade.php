@extends('admin.common.index')
@section('meta')
<link rel="stylesheet" type="text/css" href="{{asset('/admin_asset/app-assets/css/pages/dashboard-analytics.css')}}">
@endsection
@section('page_title')
{{trans('common.reservations')}}  
@endsection
@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="mb-0">Dispatched Orders</h4>
                </div> --}}
                <div class="card-content">
                    <div class="table-responsive mt-1" style="overflow: unset;">
                        <table class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th>{{trans('common.Order')}}</th>
                                    <th>{{trans('common.Status')}}</th>
                                    <th>{{trans('common.Name')}}</th>
                                    <th>{{trans('common.User Name')}}</th>
                                    <th>{{trans('common.Date')}}</th>
                                    <th>{{trans('common.Price')}}</th>
                                    <th>{{trans('common.Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                <tr>
                                    <td>#{{$reservation['id']}}</td>
                                    @if($reservation['status'] == 1)
                                    <td><i class="fa fa-circle font-small-3 text-warning mr-50"></i>{{$reservation['status_name']}}</td>
                                    @elseif($reservation['status'] == 2)
                                    <td><i class="fa fa-circle font-small-3 text-success mr-50"></i>{{$reservation['status_name']}}</td>
                                    @elseif($reservation['status'] == 3)
                                    <td><i class="fa fa-circle font-small-3 text-danger mr-50"></i>{{$reservation['status_name']}}</td>
                                    @else
                                    <td><i class="fa fa-circle font-small-3 text-danger mr-50"></i>{{$reservation['status_name']}}</td>
                                    @endif
                                    <td>{{$reservation['property_name']}}</td>
                                    <td>{{$reservation['user_name']}}</td>
                                    <td>{{$reservation['created_at']}}</td>
                                    <td>{{$reservation['final_price']}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-primary dropdown-toggle mr-1 mb-1" type="button" id="dropdownMenuButton{{$reservation['id']}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{trans('common.Actions')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$reservation['id']}}">
                                                    <a class="dropdown-item" href="{{route('show_reservation', $reservation['id'])}}">{{trans('common.Show')}}</a>
                                                    @if ($reservation['status'] == 1)
                                                    <a class="dropdown-item" href="{{route('accept_reservation', $reservation['id'])}}">{{trans('common.Accept')}}</a>
                                                    <a class="dropdown-item" href="{{route('reject_reservation', $reservation['id'])}}">{{trans('common.Reject')}}</a>
                                                    <a class="dropdown-item" href="{{route('cancel_reservation', $reservation['id'])}}">{{trans('common.Cancel')}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Analytics end -->

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center mt-3">
        {{ $data->links() }}
    </ul>
</nav>

@endsection

@section('script')
<script>

$(document).on('change', '.toggle-class', function() {
    var status = $(this).prop('checked') == true ? 1 : 0; 
    var id = $(this).data('id'); 
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{route('block_reason')}}",
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