@extends('admin.common.index')
@section('page_title')
{{trans('common.offers')}}
@endsection
@section('content')
<!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <div class="row match-height">
        @foreach($offers as $offer)
        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
            <div class="card">
                <div class="card-header mx-auto">
                    <div class="avatar avatar-xl">
                        {{-- <img class="img-fluid" src="{{$offer->image}}" alt="img placeholder"> --}}
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body text-center">
                        <h4>{{ trans('common.User') .': ' .$offer->user->name??''}}</h4>
                        <h4>{{ trans('common.Ride') .': ' .$offer->owner->name??''}}</h4>
                        <p class="">
                            @if ($offer->status==1)
                            {{ trans('common.Pending') }}
                            @elseif ($offer->status==2)
                            {{ trans('common.Accepted') }}
                            @elseif ($offer->status==3)
                            {{ trans('common.Rejected') }}
                            @elseif ($offer->status==4)
                            {{ trans('common.Canceled') }}
                        @endif</p>
                        <div class="card-btns d-flex justify-content-between">
                            <a href="{{route('show_offer', $offer->id)}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                            {{-- <a href="{{route('edit_offer', $offer->id)}}" class="btn btn-warning">{{trans('common.Edit')}}</a> --}}
                            <button data-url="{{route('delete_offer', $offer->id)}}" data-direct="{{route('offers')}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
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
        {{ $offers->links() }}
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
