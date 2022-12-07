<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">Pillow</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <!--<li class="nav-item {{request()->is('admin') ? 'active' : ''}}">-->
            <!--    <a href="{{route('dashboard')}}">-->
            <!--        <i class="feather icon-home"></i>-->
            <!--        <span class="menu-title" data-i18n="Dashboard">{{trans('common.Dashboard')}}</span>-->
            <!--    </a>-->
            <!--</li>-->

            <li class=" nav-item {{request()->is('admin') ? 'active' : ''}}">
                <a href="index.html">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">{{trans('common.Dashboard')}}</span><span class="badge badge badge-warning badge-pill float-right mr-2">2</span>
                </a>
                <ul class="menu-content">
                    <li class="active">
                        <a href="{{route('dashboard')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
                    </li>
                    {{-- <li>
                        <a href="{{route('dashboard_v2')}}"><i class="feather icon-circle"></i><span class="menu-item" data-i18n="eCommerce">Pillow</span></a>
                    </li> --}}
                </ul>
            </li>

            <!-- <li class=" navigation-header"><span>Apps</span>
            </li> -->

            {{-- <li class=" nav-item">
                <a href="{{route('chat')}}">
                    <i class="feather icon-message-square"></i>
                    <span class="menu-title" data-i18n="Chat">{{trans('common.Chat')}}</span>
                </a>
            </li> --}}

            @if(checkPermit('is_user'))
            <li class="nav-item
            {{setMenu('users')}}{{setMenu('add_user')}}{{setMenu('show_user')}}{{setMenu('edit_user')}}
            ">
                <a href="#">
                    <i class="feather icon-user"></i>
                    <span class="menu-title" data-i18n="User">{{trans('common.users')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('users')}}{{setShown('add_user')}}{{setShown('show_user')}}{{setShown('edit_user')}}
                    {{setActive('users')}}{{setActive('show_user')}}{{setActive('edit_user')}}
                    ">
                        <a href="{{route('users')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('users')}}{{setShown('add_user')}}{{setShown('show_user')}}{{setShown('edit_user')}}
                    {{setActive('add_user')}}
                    ">
                        <a href="{{route('add_user')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_ride'))
            <li class="nav-item
            {{setMenu('rides')}}{{setMenu('add_ride')}}{{setMenu('show_ride')}}{{setMenu('edit_ride')}}
            ">
                <a href="#">
                    <i class="feather icon-user"></i>
                    <span class="menu-title" data-i18n="User">{{trans('common.rides')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('rides')}}{{setShown('add_ride')}}{{setShown('show_ride')}}{{setShown('edit_ride')}}
                    {{setActive('rides')}}{{setActive('show_ride')}}{{setActive('edit_ride')}}
                    ">
                        <a href="{{route('rides')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('rides')}}{{setShown('add_ride')}}{{setShown('show_ride')}}{{setShown('edit_ride')}}
                    {{setActive('add_ride')}}
                    ">
                        <a href="{{route('add_ride')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif


            @if(checkPermit('is_furnished'))
            <li class="nav-item
            {{setMenu('apartments')}}{{setMenu('add_apartment')}}{{setMenu('show_apartment')}}{{setMenu('edit_apartment')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Properites')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('apartments')}}{{setShown('add_apartment')}}{{setShown('show_apartment')}}{{setShown('edit_apartment')}}
                    {{setActive('apartments')}}{{setActive('show_apartment')}}{{setActive('edit_apartment')}}
                    ">
                        <a href="{{route('apartments',-1)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('apartments')}}{{setShown('add_apartment')}}{{setShown('show_apartment')}}{{setShown('edit_apartment')}}
                    {{setActive('add_apartment')}}
                    ">
                        <a href="{{route('add_apartment')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_offer'))
            <li class="nav-item
            {{setActive('offers')}}{{setActive('show_offer')}}{{setActive('show_offer')}}
            ">
                <a href="{{route('offers')}}">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Dashboard">{{trans('common.Offers')}}</span>
                </a>
            </li>
            @endif
            {{-- @if(checkPermit('is_furnished'))
            <li class="nav-item
            {{setMenu('apartments')}}{{setMenu('add_apartment')}}{{setMenu('show_apartment')}}{{setMenu('edit_apartment')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Apartment')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('apartments')}}{{setShown('add_apartment')}}{{setShown('show_apartment')}}{{setShown('edit_apartment')}}
                    {{setActive('apartments')}}{{setActive('show_apartment')}}{{setActive('edit_apartment')}}
                    ">
                        <a href="{{route('apartments',1)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('apartments')}}{{setShown('add_apartment')}}{{setShown('show_apartment')}}{{setShown('edit_apartment')}}
                    {{setActive('add_apartment')}}
                    ">
                        <a href="{{route('add_apartment')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}


            {{-- @if(checkPermit('is_shared'))
            <li class="nav-item
            {{setMenu('rooms')}}{{setMenu('add_room')}}{{setMenu('show_room')}}{{setMenu('edit_room')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Shared Room')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('rooms')}}{{setShown('add_room')}}{{setShown('show_room')}}{{setShown('edit_room')}}
                    {{setActive('rooms')}}{{setActive('show_room')}}{{setActive('edit_room')}}
                    ">
                        <a href="{{route('rooms')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('rooms')}}{{setShown('add_room')}}{{setShown('show_room')}}{{setShown('edit_room')}}
                    {{setActive('add_room')}}
                    ">
                        <a href="{{route('add_room')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_restaurant'))
            <li class="nav-item
            {{setMenu('restaurants')}}{{setMenu('add_restaurant')}}{{setMenu('show_restaurant')}}{{setMenu('edit_restaurant')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Restaurant')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('restaurants')}}{{setShown('add_restaurant')}}{{setShown('show_restaurant')}}{{setShown('edit_restaurant')}}
                    {{setActive('restaurants')}}{{setActive('show_restaurant')}}{{setActive('edit_restaurant')}}
                    ">
                        <a href="{{route('restaurants')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('restaurants')}}{{setShown('add_restaurant')}}{{setShown('show_restaurant')}}{{setShown('edit_restaurant')}}
                    {{setActive('add_restaurant')}}
                    ">
                        <a href="{{route('add_restaurant')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_wedding'))
            <li class="nav-item
            {{setMenu('weddings')}}{{setMenu('add_wedding')}}{{setMenu('show_wedding')}}{{setMenu('edit_wedding')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Wedding Hall')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('weddings')}}{{setShown('add_wedding')}}{{setShown('show_wedding')}}{{setShown('edit_wedding')}}
                    {{setActive('weddings')}}{{setActive('show_wedding')}}{{setActive('edit_wedding')}}
                    ">
                        <a href="{{route('weddings')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('weddings')}}{{setShown('add_wedding')}}{{setShown('show_wedding')}}{{setShown('edit_wedding')}}
                    {{setActive('add_wedding')}}
                    ">
                        <a href="{{route('add_wedding')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_travel'))
            <li class="nav-item
            {{setMenu('travels')}}{{setMenu('add_travel')}}{{setMenu('show_travel')}}{{setMenu('edit_travel')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Travel Agency')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('travels')}}{{setShown('add_travel')}}{{setShown('show_travel')}}{{setShown('edit_travel')}}
                    {{setActive('travels')}}{{setActive('show_travel')}}{{setActive('edit_travel')}}
                    ">
                        <a href="{{route('travels')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('travels')}}{{setShown('add_travel')}}{{setShown('show_travel')}}{{setShown('edit_travel')}}
                    {{setActive('add_travel')}}
                    ">
                        <a href="{{route('add_travel')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_business'))
            <li class="nav-item
            {{setMenu('businesses')}}{{setMenu('add_business')}}{{setMenu('show_business')}}{{setMenu('edit_business')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Business Space')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('businesses')}}{{setShown('add_business')}}{{setShown('show_business')}}{{setShown('edit_business')}}
                    {{setActive('businesses')}}{{setActive('show_business')}}{{setActive('edit_business')}}
                    ">
                        <a href="{{route('businesses')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('businesses')}}{{setShown('add_business')}}{{setShown('show_business')}}{{setShown('edit_business')}}
                    {{setActive('add_business')}}
                    ">
                        <a href="{{route('add_business')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_residential'))
            <li class="nav-item
            {{setMenu('residentials')}}{{setMenu('add_residential')}}{{setMenu('show_residential')}}{{setMenu('edit_residential')}}
            ">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="menu-title" data-i18n="Furnished Apartment">{{trans('common.Residential')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('residentials')}}{{setShown('add_residential')}}{{setShown('show_residential')}}{{setShown('edit_residential')}}
                    {{setActive('residentials')}}{{setActive('show_residential')}}{{setActive('edit_residential')}}
                    ">
                        <a href="{{route('residentials')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('residentials')}}{{setShown('add_residential')}}{{setShown('show_residential')}}{{setShown('edit_residential')}}
                    {{setActive('add_residential')}}
                    ">
                        <a href="{{route('add_residential')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}

            @if(checkPermit('is_attributes'))
            <li class="nav-item
            {{setMenu('attributes')}}{{setMenu('add_attribute')}}{{setMenu('show_attribute')}}{{setMenu('edit_attribute')}}
            {{setMenu('attribute_value')}}{{setMenu('add_attribute_value')}}{{setMenu('show_attribute_value')}}{{setMenu('edit_attribute_value')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Attributes')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('attributes')}}{{setShown('add_attribute')}}{{setShown('show_attribute')}}{{setShown('edit_attribute')}}
                    {{setActive('attributes')}}{{setActive('show_attribute')}}{{setActive('edit_attribute')}}
                    {{setShown('attribute_value')}}{{setShown('add_attribute_value')}}{{setShown('show_attribute_value')}}{{setShown('edit_attribute_value')}}
                    {{setActive('attribute_value')}}{{setActive('add_attribute_value')}}{{setActive('show_attribute_value')}}{{setActive('edit_attribute_value')}}
                    ">
                        <a href="{{route('attributes')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('attributes')}}{{setShown('add_attribute')}}{{setShown('show_attribute')}}{{setShown('edit_attribute')}}
                    {{setActive('add_attribute')}}
                    ">
                        <a href="{{route('add_attribute')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- @if(checkPermit('is_book_list'))
            <li class="nav-item
            {{setMenu('books')}}{{setMenu('add_book')}}{{setMenu('show_book')}}{{setMenu('edit_book')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Book List')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('books')}}{{setShown('add_book')}}{{setShown('show_book')}}{{setShown('edit_book')}}
                    {{setActive('books')}}{{setActive('show_book')}}{{setActive('edit_book')}}
                    ">
                        <a href="{{route('books')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('books')}}{{setShown('add_book')}}{{setShown('show_book')}}{{setShown('edit_book')}}
                    {{setActive('add_book')}}
                    ">
                        <a href="{{route('add_book')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_through'))
            <li class="nav-item
            {{setMenu('throughs')}}{{setMenu('add_through')}}{{setMenu('show_through')}}{{setMenu('edit_through')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Through')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('throughs')}}{{setShown('add_through')}}{{setShown('show_through')}}{{setShown('edit_through')}}
                    {{setActive('throughs')}}{{setActive('show_through')}}{{setActive('edit_through')}}
                    ">
                        <a href="{{route('throughs')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('throughs')}}{{setShown('add_through')}}{{setShown('show_through')}}{{setShown('edit_through')}}
                    {{setActive('add_through')}}
                    ">
                        <a href="{{route('add_through')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_include'))
            <li class="nav-item
            {{setMenu('includes')}}{{setMenu('add_include')}}{{setMenu('show_include')}}{{setMenu('edit_include')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Include')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('includes')}}{{setShown('add_include')}}{{setShown('show_include')}}{{setShown('edit_include')}}
                    {{setActive('includes')}}{{setActive('show_include')}}{{setActive('edit_include')}}
                    ">
                        <a href="{{route('includes')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('includes')}}{{setShown('add_include')}}{{setShown('show_include')}}{{setShown('edit_include')}}
                    {{setActive('add_include')}}
                    ">
                        <a href="{{route('add_include')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_residential_type'))
            <li class="nav-item
            {{setMenu('residential_type')}}{{setMenu('add_residential_type')}}{{setMenu('show_residential_type')}}{{setMenu('edit_residential_type')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Residential Type')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('residential_type')}}{{setShown('add_residential_type')}}{{setShown('show_residential_type')}}{{setShown('edit_residential_type')}}
                    {{setActive('residential_type')}}{{setActive('show_residential_type')}}{{setActive('edit_residential_type')}}
                    ">
                        <a href="{{route('residential_type')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('residential_type')}}{{setShown('add_residential_type')}}{{setShown('show_residential_type')}}{{setShown('edit_residential_type')}}
                    {{setActive('add_residential_type')}}
                    ">
                        <a href="{{route('add_residential_type')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}

            @if(checkPermit('is_gallary'))
            <li class="nav-item
            {{setMenu('gallaries')}}{{setMenu('add_gallary')}}{{setMenu('show_gallary')}}{{setMenu('edit_gallary')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.gallary')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('gallaries')}}{{setShown('add_gallary')}}{{setShown('show_gallary')}}{{setShown('edit_gallary')}}
                    {{setActive('gallaries')}}{{setActive('show_gallary')}}{{setActive('edit_gallary')}}
                    ">
                        <a href="{{route('gallaries')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('gallaries')}}{{setShown('add_gallary')}}{{setShown('show_gallary')}}{{setShown('edit_gallary')}}
                    {{setActive('add_gallary')}}
                    ">
                        <a href="{{route('add_gallary')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- @if(checkPermit('is_term')) --}}
            {{-- <li class="nav-item
            {{setMenu('termconditions')}}{{setMenu('add_term')}}{{setMenu('show_term')}}{{setMenu('edit_term')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('Term')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('termconditions')}}{{setShown('add_term')}}{{setShown('show_term')}}{{setShown('edit_term')}}
                    {{setActive('termconditions')}}{{setActive('show_term')}}{{setActive('edit_term')}}
                    ">
                        <a href="{{route('termconditions')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('termconditions')}}{{setShown('add_term')}}{{setShown('show_term')}}{{setShown('edit_term')}}
                    {{setActive('add_term')}}
                    ">
                        <a href="{{route('add_term')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            {{-- @endif --}}

            @if(checkPermit('is_country'))
            <li class="nav-item
            {{setMenu('countries')}}{{setMenu('add_country')}}{{setMenu('show_country')}}{{setMenu('edit_country')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Country')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('countries')}}{{setShown('add_country')}}{{setShown('show_country')}}{{setShown('edit_country')}}
                    {{setActive('countries')}}{{setActive('show_country')}}{{setActive('edit_country')}}
                    ">
                        <a href="{{route('countries')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('countries')}}{{setShown('add_country')}}{{setShown('show_country')}}{{setShown('edit_country')}}
                    {{setActive('add_country')}}
                    ">
                        <a href="{{route('add_country')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(checkPermit('is_city'))
            <li class="nav-item
            {{setMenu('cities')}}{{setMenu('add_city')}}{{setMenu('show_city')}}{{setMenu('edit_city')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.City')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('cities')}}{{setShown('add_city')}}{{setShown('show_city')}}{{setShown('edit_city')}}
                    {{setActive('cities')}}{{setActive('show_city')}}{{setActive('edit_city')}}
                    ">
                        <a href="{{route('cities')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('cities')}}{{setShown('add_city')}}{{setShown('show_city')}}{{setShown('edit_city')}}
                    {{setActive('add_city')}}
                    ">
                        <a href="{{route('add_city')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- @if(checkPermit('is_reason'))
            <li class="nav-item
            {{setMenu('reasons')}}{{setMenu('add_reason')}}{{setMenu('show_reason')}}{{setMenu('edit_reason')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Reason')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('reasons')}}{{setShown('add_reason')}}{{setShown('show_reason')}}{{setShown('edit_reason')}}
                    {{setActive('reasons')}}{{setActive('show_reason')}}{{setActive('edit_reason')}}
                    ">
                        <a href="{{route('reasons')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reasons')}}{{setShown('add_reason')}}{{setShown('show_reason')}}{{setShown('edit_reason')}}
                    {{setActive('add_reason')}}
                    ">
                        <a href="{{route('add_reason')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}

            {{-- @if(checkPermit('is_coupon'))
            <li class="nav-item
            {{setMenu('coupons')}}{{setMenu('add_coupon')}}{{setMenu('show_coupon')}}{{setMenu('edit_coupon')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Coupon')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('coupons')}}{{setShown('add_coupon')}}{{setShown('show_coupon')}}{{setShown('edit_coupon')}}
                    {{setActive('coupons')}}{{setActive('show_coupon')}}{{setActive('edit_coupon')}}
                    ">
                        <a href="{{route('coupons')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('coupons')}}{{setShown('add_coupon')}}{{setShown('show_coupon')}}{{setShown('edit_coupon')}}
                    {{setActive('add_coupon')}}
                    ">
                        <a href="{{route('add_coupon')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}

            @if(checkPermit('is_property'))
            {{-- <li class="nav-item
            {{setActive('properties')}}{{setActive('show_property')}}{{setActive('edit_property')}}
            ">
                <a href="{{route('properties')}}">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Dashboard">{{trans('common.Property')}}</span>
                </a>
            </li> --}}

            <li class="nav-item
            {{setMenu('properties')}}{{setMenu('add_property')}}{{setMenu('show_property')}}{{setMenu('edit_property')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Property')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('properties')}}{{setShown('add_property')}}{{setShown('show_property')}}{{setShown('edit_property')}}
                    {{setActive('properties')}}{{setActive('show_property')}}{{setActive('edit_property')}}
                    ">
                        <a href="{{route('properties')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.List')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('properties')}}{{setShown('add_property')}}{{setShown('show_property')}}{{setShown('edit_property')}}
                    {{setActive('add_property')}}
                    ">
                        <a href="{{route('add_property')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Add')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif



            @if(checkPermit('is_property'))
            <li class="nav-item
            {{setActive('show_information')}}{{setActive('show_information')}}{{setActive('show_information')}}
            ">
                <a href="{{route('show_information')}}">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Dashboard">{{trans('common.Information')}}</span>
                </a>
            </li>
            @endif
            {{-- @if(checkPermit('is_property'))
            <li class="nav-item
            {{setActive('properties')}}{{setActive('show_property')}}{{setActive('edit_property')}}
            ">
                <a href="{{route('properties')}}">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Dashboard">{{trans('common.Property')}}</span>
                </a>
            </li>
            @endif

            @if(checkPermit('is_reservation'))
            <li class="nav-item
            {{setMenu('reservations')}}{{setMenu('show_reservation')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Reservation')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 1))}}
                    ">
                        <a href="{{route('reservations', 1)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.Hotel')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 2))}}
                    ">
                        <a href="{{route('reservations', 2)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Furnished Apartment')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 3))}}
                    ">
                        <a href="{{route('reservations', 3)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Shared Room')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 4))}}
                    ">
                        <a href="{{route('reservations', 4)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Restaurant')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 5))}}
                    ">
                        <a href="{{route('reservations', 5)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Wedding Hall')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 6))}}
                    ">
                        <a href="{{route('reservations', 6)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Travel Agency')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 7))}}
                    ">
                        <a href="{{route('reservations', 7)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Business Space')}}</span>
                        </a>
                    </li> --}}
                    {{-- <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 8))}}
                    ">
                        <a href="{{route('reservations', 8)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Car')}}</span>
                        </a>
                    </li> --}}
                    {{-- <li class="
                    {{setShown('reservations')}}{{setShown('show_reservation')}}
                    {{setActiveParameter(route('reservations', 9))}}
                    ">
                        <a href="{{route('reservations', 9)}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Residential')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif --}}

            @if(checkPermit('is_admin'))
            <li class="nav-item
            {{setMenu('admins')}}{{setMenu('add_admin')}}{{setMenu('show_admin')}}{{setMenu('edit_admin')}}
            {{setMenu('permissions')}}{{setMenu('add_permission')}}{{setMenu('show_permission')}}{{setMenu('edit_permission')}}
            ">
                <a href="#">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title" data-i18n="Attribute">{{trans('common.Administration')}}</span>
                </a>
                <ul class="menu-content">
                    <li class="
                    {{setShown('admins')}}{{setShown('add_admin')}}{{setShown('show_admin')}}{{setShown('edit_admin')}}
                    {{setActive('admins')}}{{setActive('add_admin')}}{{setActive('show_admin')}}{{setActive('edit_admin')}}
                    ">
                        <a href="{{route('admins')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="List">{{trans('common.Admin')}}</span>
                        </a>
                    </li>
                    <li class="
                    {{setShown('permissions')}}{{setShown('add_permission')}}{{setShown('show_permission')}}{{setShown('edit_permission')}}
                    {{setActive('permissions')}}{{setActive('add_permission')}}{{setActive('show_permission')}}{{setActive('edit_permission')}}
                    ">
                        <a href="{{route('permissions')}}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item" data-i18n="Edit">{{trans('common.Permission')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
