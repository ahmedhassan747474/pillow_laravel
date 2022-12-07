@extends('admin.common.index')
@section('page_title')
{{trans('common.Properites')}}
@endsection
@section('content')
<!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <form action="" method="get">
    <div class="row match-height">
            <div class="col-xl-6 col-md-6 col-sm-6">
                <?php $types = [
                    'Apartment',
                    'Villa',
                    'Administrative',
                    'Shop',
                    'Chalet',
                    'Land',
                    'Farms',
                    'Factories',
                    ];
                ?>

                {{-- <div class="form-group">
                    <label>{{trans('common.Select Type')}}</label>
                    <select class="form-control" name="type" id="select-opt" required>
                        <option value="-1">{{trans('common.All') . trans('common.Properites')}}</option>
                        <option value="-2" {{ $type == -2 ? 'selected' :''}}>{{ trans('common.Popular')}}</option>
                        @foreach ($types as $index=>$item)
                            <option value="{{ route('apartments',$index+1) }}" {{ $type == $index+1 ? 'selected' :''}}>{{trans('common.'.$item)}}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group">
                    <label>{{trans('common.Select Type')}}</label>
                    <select class="form-control" name="type" id="select-opt" required>
                        <option value="-1">{{trans('common.All') . trans('common.Properites')}}</option>
                        <option value="-2" {{ $type == -2 ? 'selected' :''}}>{{ trans('common.Popular')}}</option>
                        @foreach (\App\PropertyList::where('status','1')->orderBy('name_ar')->get() as $index=>$item)
                            <option value="{{ route('apartments',$item->id) }}" {{ $type == $item->id ? 'selected' :''}}>{{$item->name_ar}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-4">
                <div class="form-group">
                    <label>{{trans('common.search')}}</label>
                    <input type="text" name="search" value="{{ $search }}" class="form-control">
                </div>
            </div>
            <div class="col-xl-2 col-md-2 col-sm-2">
                <div class="form-group">
                    <label></label>
                    <br>
                    <input type="submit" value="{{trans('common.search')}}" class="btn btn-primary">
                </div>
            </div>
       </form>
        @foreach($apartments as $apartment)
        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <img class="card-img img-fluid mb-1" src="{{$apartment['image']}}" alt="Card image cap" style="height: 260px;">
                        <h5 class="my-1">{{$apartment['name']}}</h5>
                        <p class="card-text  mb-0">{{$apartment['city_name']}}, {{$apartment['country_name']}}</p>
                        <span class="card-text">$ {{$apartment['price']}}</span>
                        <hr class="my-1">
                        <div class="card-btns d-flex justify-content-between">
                            <a href="{{route('show_apartment', $apartment['id'])}}" class="btn btn-primary">{{trans('common.Show')}}</a>
                            <a href="{{route('edit_apartment', $apartment['id'])}}" class="btn btn-warning">{{trans('common.Edit')}}</a>
                            <button data-url="{{route('delete_apartment', $apartment['id'])}}" data-direct="{{route('apartments',$apartment['type'])}}" class="btn btn-danger delete-ajax">{{trans('common.Delete')}}</a>
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
        {{ $data->links() }}
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

$(document).ready(function () {
  $("#select-opt").change(function() {
    var $option = $(this).find(':selected');
    var url = $option.val();
    if (url != "") {

        window.location.href = url;
    //   url += "?text=" + encodeURIComponent($option.text());
      // Show URL rather than redirect
    //   $("#output").text(url);
    }
  });
});

</script>
@endsection
