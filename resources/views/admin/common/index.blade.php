<!DOCTYPE html>
@if(session()->get('back_locale') == 'ar')
<html class="loading" lang="en" data-textdirection="rtl">
@else
<html class="loading" lang="en" data-textdirection="ltr">
@endif
<!-- BEGIN: Head-->

@include('admin.common.meta')

<!-- END: Head-->

<!-- BEGIN: Body-->

@if(session()->get('lite_mode') == 'dark')
<body class="vertical-layout vertical-menu-modern dark-layout 2-columns @yield('class_body') navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="dark-layout">
@else
<body class="vertical-layout vertical-menu-modern 2-columns @yield('class_body') navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@endif
    <!-- BEGIN: Header-->
    @include('admin.common.navbar')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('admin.common.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        @if(request()->is('admin/chat'))

        <div class="content-area-wrapper">
            @yield('content')
        </div>
        
        @else

        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>

        @endif

    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('admin.common.footer')
    <!-- END: Footer-->

    <!-- BEGIN: Script-->
    @include('admin.common.script')
    <!-- END: Script-->
</body>
<!-- END: Body-->

</html>