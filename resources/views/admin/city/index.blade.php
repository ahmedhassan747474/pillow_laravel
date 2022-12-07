@extends('admin.common.index')
@section('page_title')
    {{ trans('common.cities') }}
@endsection
@section('content')
    <section id="basic-examples">

        <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('common.Name') }}</th>
                        <th scope="col">{{trans('common.Status')}}</th>
                        <th scope="col" width="47%">action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    
                    ?>

                    @foreach ($cities as $city)
                        <tr>

                            {{-- </th> --}}
                            <td>{{ $i }}</td>
                            <td>{{ $city->name }}</td>
                            <td>     <div class="col-md-6">
                    <div class="custom-control custom-switch switch-lg custom-switch-success mr-2">
                        <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$city->id}}" id="customSwitch{{$city->id}}" {{ $city->status == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customSwitch{{$city->id}}">
                            <span class="switch-text-left">{{trans('common.Active')}}</span>
                            <span class="switch-text-right">{{trans('common.Block')}}</span>
                        </label>
                    </div>
                </div></td>

                            <td>

                                {{-- <div class="card-btns d-flex justify-content-between"> --}}
                                <a href="{{ route('show_city', $city->id) }}"
                                    class="btn btn-primary">{{ trans('common.Show') }}</a>
                                <a href="{{ route('edit_city', $city->id) }}"
                                    class="btn btn-warning">{{ trans('common.Edit') }}</a>
                                <button data-url="{{ route('delete_city', $city->id) }}" data-direct="{{ route('cities') }}"
                                    class="btn btn-danger delete-ajax">{{ trans('common.Delete') }}</a>
                                    {{-- </div> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
    {{-- <!-- Basic example and Profile cards section start -->
<section id="basic-examples">
    <div class="row match-height">

        <!-- Profile Cards Starts -->
        <div class="col-xl-4 col-md-6 col-sm-12 profile-card-1">
            <div class="card">
                <div class="card-content">
                    <div class="card-body text-center">

                        <div class="row">
                            <div class="col-md-6">
                                <h5></h5>
                            </div>
                            <div class="col-md-6">
                                <h4></h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>{{trans('common.Country Name')}}</h5>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5></h5>
                            </div>
                       
                        </div>

                        <hr class="my-1">
                    
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Cards Ends -->
        @endforeach
    </div> --}}
    {{-- </section> --}}

    {{-- <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-3">
            {{ $cities->links() }}
        </ul>
    </nav> --}}
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
                url: "{{ route('block_city') }}",
                data: {
                    'status': status,
                    'id': id
                },
                success: function(data) {
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
                title: "{{ trans('common.Are you sure?') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ trans('common.Yes, delete it') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: "{{ trans('common.Deleted Successfully') }}",
                                showConfirmButton: false
                            })
                            setTimeout(function() {
                                window.location.href = direct;
                            }, 2000);
                        }
                    });
                }
            })
        })
    </script>
@endsection
