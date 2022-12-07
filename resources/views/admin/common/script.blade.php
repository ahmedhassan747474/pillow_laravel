<!-- BEGIN: Vendor JS-->
<script src="{{asset('/admin_asset/app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- <script src="{{asset('/admin_asset/assets/js/scripts.js')}}"></script>
<script src="{{asset('/admin_asset/assets/js/bidsbooking_custom.js')}}"></script> -->
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
@yield('script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('/admin_asset/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/js/core/app.js')}}"></script>
<script src="{{asset('/admin_asset/app-assets/js/scripts/components.js')}}"></script>

<!-- END: Theme JS-->

@yield('script_chat')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
	
	$.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

	// Get Cities From Country ID
    $('.country').on('click', function() {
        var country = $(this).val();
        // var id = $(this).data('id');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '{{route('get_cities')}}',
            data: {'country_id': country},
            success: function(data){
                var append = "<option value='' selected disabled>{{trans('common.Select City')}}</option>";
                for (i = 0; i < data.length; i++) {
                    append += "<option value='"+ data[i].id +"'>"+ data[i].name +"</option>"
                }
                $('.city').html(append);
            }
        });
    })

    $(function () {
        var inputs = document.getElementsByTagName("INPUT");
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].oninvalid = function (e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity(e.target.getAttribute("data-error"));
                }
            };
        }
    });
</script>

