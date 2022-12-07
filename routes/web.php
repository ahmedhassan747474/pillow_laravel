<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



// Route::get('/', function() {
//         return view('welcome');
//     });
    Route::get('/hm', function() {
      $output_file = 'qrcodes/qrcode' . 'i' . '.svg';
         return QrCode::format('png')->merge('/public/022.PNG')->generate('https://reeqalnahl.shop/gift/', $output_file);
    });


    // Route::get('/run-migrations', function () {
    //     return Artisan::call('migrate', ["--force" => true ]);
    // });
Route::get('/chats', 'ChatController@index');
Route::get('/messages', 'ChatController@fetchMessages');
Route::post('/messages', 'ChatController@sendMessage');

Route::get('/lite_mode/{color}', function ($color){
    session()->put('lite_mode', $color);
    return redirect()->back();
})->name('lite_mode');

Route::get('/front_language/{locale}', function ($locale){
    App::setLocale($locale);
    session()->put('front_locale', $locale);
    return redirect()->back();
})->name('front_language');

Route::get('/back_language/{locale}', function ($locale){
    App::setLocale($locale);
    session()->put('back_locale', $locale);
    return redirect()->back();
})->name('back_language');

Route::group(['namespace' => 'Front'], function () {

    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login', 'UserController@login')->name('login');
        Route::post('/login/check', 'UserController@checkLogin');
        Route::get('reset-password/{token}', 'UserController@resetPassword')->name('reset-password');
        Route::post('change-password', 'UserController@changePassword')->name('change-password');
        Route::get('registeration', 'UserController@registeration')->name('registeration');
        Route::post('submit-registeration', 'UserController@submitRegisteration')->name('submit-registeration');
        Route::get('active-email/{token}/{uid}', 'UserController@activeEmail')->name('active-email');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index')->name('front-home');
        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::get('/logout', 'UserController@logout')->name('user.logout');
        Route::put('submit-update-profile', 'UserController@updateProfile')->name('user-submit-update-profile');
    });


});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'back_language'], function () {
    // Admin Login
    Route::get('/login', 'LoginController@login')->name('admin_login');
    Route::post('/admin_check_login', 'LoginController@checkLogin')->name('admin_check_login');
    //Admin Forget Password
    Route::get('/admin_forget_password', 'LoginController@forgetPassword')->name('admin_forget_password');
    Route::post('/admin_forget_password_check', 'LoginController@forgetPasswordCheck')->name('admin_forget_password_check');
    Route::post('/admin_change_password', 'LoginController@changePassword')->name('admin_change_password');
    Route::get('/reset_password', 'LoginController@resetPassword')->name('reset_password');

    Route::group(['middleware' =>  'admin'], function () {
        //Admin Edit and Logout
        Route::get('/admin_profile', 'LoginController@edit')->name('edit_admin_profile');
        Route::post('/admin_profile', 'LoginController@update')->name('update_admin_profile');
        Route::get('/logout', 'LoginController@logout')->name('admin_logout');
        //Dashboard
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/detailsChart/{type}', 'DashboardController@detailsChart')->name('dashboard.detailsChart');
        Route::get('/dashboard_v2', 'DashboardController@index_v2')->name('dashboard_v2');
        //User
        Route::get('/users', 'UserController@index')->name('users');
        Route::get('/add_user', 'UserController@create')->name('add_user');
        Route::post('/add_user', 'UserController@store')->name('store_user');
        Route::get('/show_user/{id}', 'UserController@show')->name('show_user');
        Route::get('/edit_user/{id}', 'UserController@edit')->name('edit_user');
        Route::post('/edit_user/{id}', 'UserController@update')->name('update_user');
        Route::get('/delete_user/{id}', 'UserController@destroy')->name('delete_user');
        Route::get('/block_user', 'UserController@blockUser')->name('block_user');
        Route::get('/user_filter', 'UserController@filter')->name('user_filter');
        //Ride
        Route::get('/rides', 'RideController@index')->name('rides');
        Route::get('/add_ride', 'RideController@create')->name('add_ride');
        Route::post('/add_ride', 'RideController@store')->name('store_ride');
        Route::get('/show_ride/{id}', 'RideController@show')->name('show_ride');
        Route::get('/edit_ride/{id}', 'RideController@edit')->name('edit_ride');
        Route::post('/edit_ride/{id}', 'RideController@update')->name('update_ride');
        Route::get('/delete_ride/{id}', 'RideController@destroy')->name('delete_ride');
        Route::get('/block_ride', 'RideController@blockRide')->name('block_ride');

        Route::get('/offers', 'OfferController@index')->name('offers');
        Route::get('/add_offer', 'OfferController@create')->name('add_offer');
        Route::post('/add_offer', 'OfferController@store')->name('store_offer');
        Route::get('/show_offer/{id}', 'OfferController@show')->name('show_offer');
        Route::get('/edit_offer/{id}', 'OfferController@edit')->name('edit_offer');
        Route::post('/edit_offer/{id}', 'OfferController@update')->name('update_offer');
        Route::get('/delete_offer/{id}', 'OfferController@destroy')->name('delete_offer');
        Route::get('/block_offer', 'OfferController@blockOffer')->name('block_offer');

        //Hotel
        Route::get('/hotels', 'HotelController@index')->name('hotels');
        Route::get('/add_hotel', 'HotelController@create')->name('add_hotel');
        Route::post('/add_hotel', 'HotelController@store')->name('store_hotel');
        Route::get('/show_hotel/{id}', 'HotelController@show')->name('show_hotel');
        Route::get('/edit_hotel/{id}', 'HotelController@edit')->name('edit_hotel');
        Route::post('/edit_hotel/{id}', 'HotelController@update')->name('update_hotel');
        Route::get('/delete_hotel/{id}', 'HotelController@destroy')->name('delete_hotel');
        Route::get('/block_property', 'HotelController@blockProperty')->name('block_property');
        Route::post('/image_property', 'HotelController@imageProperty')->name('image_property');

        //property
        // Route::get('/properties', 'PropertyController@index')->name('properties');
        // Route::get('/add_property', 'PropertyController@create')->name('add_property');
        // Route::post('/add_property', 'PropertyController@store')->name('store_property');
        // Route::get('/show_property/{id}', 'PropertyController@show')->name('show_property');
        // Route::get('/edit_property/{id}', 'PropertyController@edit')->name('edit_property');
        // Route::post('/edit_property/{id}', 'PropertyController@update')->name('update_property');
        // Route::get('/delete_property/{id}', 'PropertyController@destroy')->name('delete_property');
        // Route::get('/block_property', 'PropertyController@blockProperty')->name('block_property');
        // Route::post('/image_property', 'PropertyController@imageProperty')->name('image_property');

        //Rooms of Hotel
        Route::get('/hotel_room/{id}', 'HotelRoomController@index')->name('hotel_room');
        Route::get('/add_hotel_room/{id}', 'HotelRoomController@create')->name('add_hotel_room');
        Route::post('/add_hotel_room/{id}', 'HotelRoomController@store')->name('store_hotel_room');
        Route::get('/show_hotel_room/{id}', 'HotelRoomController@show')->name('show_hotel_room');
        Route::get('/edit_hotel_room/{id}', 'HotelRoomController@edit')->name('edit_hotel_room');
        Route::post('/edit_hotel_room/{id}', 'HotelRoomController@update')->name('update_hotel_room');
        Route::get('/delete_hotel_room/{id}', 'HotelRoomController@destroy')->name('delete_hotel_room');
        //Furnished Apartment
        Route::get('/apartments/{type}', 'FurnishedApartmentController@index')->name('apartments');
        Route::get('/add_apartment', 'FurnishedApartmentController@create')->name('add_apartment');
        Route::post('/add_apartment', 'FurnishedApartmentController@store')->name('store_apartment');
        Route::get('/show_apartment/{id}', 'FurnishedApartmentController@show')->name('show_apartment');
        Route::get('/edit_apartment/{id}', 'FurnishedApartmentController@edit')->name('edit_apartment');
        Route::post('/edit_apartment/{id}', 'FurnishedApartmentController@update')->name('update_apartment');
        Route::get('/delete_apartment/{id}', 'FurnishedApartmentController@destroy')->name('delete_apartment');
        //Shared Room
        Route::get('/rooms', 'SharedRoomController@index')->name('rooms');
        Route::get('/add_room', 'SharedRoomController@create')->name('add_room');
        Route::post('/add_room', 'SharedRoomController@store')->name('store_room');
        Route::get('/show_room/{id}', 'SharedRoomController@show')->name('show_room');
        Route::get('/edit_room/{id}', 'SharedRoomController@edit')->name('edit_room');
        Route::post('/edit_room/{id}', 'SharedRoomController@update')->name('update_room');
        Route::get('/delete_room/{id}', 'SharedRoomController@destroy')->name('delete_room');
        //Restaurant
        Route::get('/restaurants', 'RestaurantController@index')->name('restaurants');
        Route::get('/add_restaurant', 'RestaurantController@create')->name('add_restaurant');
        Route::post('/add_restaurant', 'RestaurantController@store')->name('store_restaurant');
        Route::get('/show_restaurant/{id}', 'RestaurantController@show')->name('show_restaurant');
        Route::get('/edit_restaurant/{id}', 'RestaurantController@edit')->name('edit_restaurant');
        Route::post('/edit_restaurant/{id}', 'RestaurantController@update')->name('update_restaurant');
        Route::get('/delete_restaurant/{id}', 'RestaurantController@destroy')->name('delete_restaurant');
        //Wedding Hall
        Route::get('/weddings', 'WeddingHallController@index')->name('weddings');
        Route::get('/add_wedding', 'WeddingHallController@create')->name('add_wedding');
        Route::post('/add_wedding', 'WeddingHallController@store')->name('store_wedding');
        Route::get('/show_wedding/{id}', 'WeddingHallController@show')->name('show_wedding');
        Route::get('/edit_wedding/{id}', 'WeddingHallController@edit')->name('edit_wedding');
        Route::post('/edit_wedding/{id}', 'WeddingHallController@update')->name('update_wedding');
        Route::get('/delete_wedding/{id}', 'WeddingHallController@destroy')->name('delete_wedding');
        //Travel Agency
        Route::get('/travels', 'TravelAgencyController@index')->name('travels');
        Route::get('/add_travel', 'TravelAgencyController@create')->name('add_travel');
        Route::post('/add_travel', 'TravelAgencyController@store')->name('store_travel');
        Route::get('/show_travel/{id}', 'TravelAgencyController@show')->name('show_travel');
        Route::get('/edit_travel/{id}', 'TravelAgencyController@edit')->name('edit_travel');
        Route::post('/edit_travel/{id}', 'TravelAgencyController@update')->name('update_travel');
        Route::get('/delete_travel/{id}', 'TravelAgencyController@destroy')->name('delete_travel');
        //Business Space
        Route::get('/businesses', 'BusinessSpaceController@index')->name('businesses');
        Route::get('/add_business', 'BusinessSpaceController@create')->name('add_business');
        Route::post('/add_business', 'BusinessSpaceController@store')->name('store_business');
        Route::get('/show_business/{id}', 'BusinessSpaceController@show')->name('show_business');
        Route::get('/edit_business/{id}', 'BusinessSpaceController@edit')->name('edit_business');
        Route::post('/edit_business/{id}', 'BusinessSpaceController@update')->name('update_business');
        Route::get('/delete_business/{id}', 'BusinessSpaceController@destroy')->name('delete_business');
        //Residential
        Route::get('/residentials', 'ResidentialController@index')->name('residentials');
        Route::get('/add_residential', 'ResidentialController@create')->name('add_residential');
        Route::post('/add_residential', 'ResidentialController@store')->name('store_residential');
        Route::get('/show_residential/{id}', 'ResidentialController@show')->name('show_residential');
        Route::get('/edit_residential/{id}', 'ResidentialController@edit')->name('edit_residential');
        Route::post('/edit_residential/{id}', 'ResidentialController@update')->name('update_residential');
        Route::get('/delete_residential/{id}', 'ResidentialController@destroy')->name('delete_residential');
        //Ajax
        Route::post('/get_cities', 'AjaxController@getCities')->name('get_cities');
        //Attributes
        Route::get('/attributes', 'AttributeController@index')->name('attributes');
        Route::get('/add_attribute', 'AttributeController@create')->name('add_attribute');
        Route::post('/add_attribute', 'AttributeController@store')->name('store_attribute');
        Route::get('/show_attribute/{id}', 'AttributeController@show')->name('show_attribute');
        Route::get('/edit_attribute/{id}', 'AttributeController@edit')->name('edit_attribute');
        Route::post('/edit_attribute/{id}', 'AttributeController@update')->name('update_attribute');
        Route::get('/delete_attribute/{id}', 'AttributeController@destroy')->name('delete_attribute');
        Route::get('/block_attribute', 'AttributeController@blockAttribute')->name('block_attribute');
        //Attributes Values
        Route::get('/attribute_value/{id}', 'AttributeValueController@index')->name('attribute_value');
        Route::get('/add_attribute_value/{id}', 'AttributeValueController@create')->name('add_attribute_value');
        Route::post('/add_attribute_value/{id}', 'AttributeValueController@store')->name('store_attribute_value');
        Route::get('/show_attribute_value/{id}', 'AttributeValueController@show')->name('show_attribute_value');
        Route::get('/edit_attribute_value/{id}', 'AttributeValueController@edit')->name('edit_attribute_value');
        Route::post('/edit_attribute_value/{id}', 'AttributeValueController@update')->name('update_attribute_value');
        Route::get('/delete_attribute_value/{id}', 'AttributeValueController@destroy')->name('delete_attribute_value');
        Route::get('/block_attribute_value', 'AttributeValueController@blockAttributeValue')->name('block_attribute_value');
        //Book List
        Route::get('/books', 'BookListController@index')->name('books');
        Route::get('/add_book', 'BookListController@create')->name('add_book');
        Route::post('/add_book', 'BookListController@store')->name('store_book');
        Route::get('/show_book/{id}', 'BookListController@show')->name('show_book');
        Route::get('/edit_book/{id}', 'BookListController@edit')->name('edit_book');
        Route::post('/edit_book/{id}', 'BookListController@update')->name('update_book');
        Route::get('/delete_book/{id}', 'BookListController@destroy')->name('delete_book');
        Route::get('/block_book', 'BookListController@blockBook')->name('block_book');
        //Through
        Route::get('/throughs', 'ThroughController@index')->name('throughs');
        Route::get('/add_through', 'ThroughController@create')->name('add_through');
        Route::post('/add_through', 'ThroughController@store')->name('store_through');
        Route::get('/show_through/{id}', 'ThroughController@show')->name('show_through');
        Route::get('/edit_through/{id}', 'ThroughController@edit')->name('edit_through');
        Route::post('/edit_through/{id}', 'ThroughController@update')->name('update_through');
        Route::get('/delete_through/{id}', 'ThroughController@destroy')->name('delete_through');
        Route::get('/block_through', 'ThroughController@blockThrough')->name('block_through');
        //Include
        Route::get('/includes', 'IncludeController@index')->name('includes');
        Route::get('/add_include', 'IncludeController@create')->name('add_include');
        Route::post('/add_include', 'IncludeController@store')->name('store_include');
        Route::get('/show_include/{id}', 'IncludeController@show')->name('show_include');
        Route::get('/edit_include/{id}', 'IncludeController@edit')->name('edit_include');
        Route::post('/edit_include/{id}', 'IncludeController@update')->name('update_include');
        Route::get('/delete_include/{id}', 'IncludeController@destroy')->name('delete_include');
        Route::get('/block_include', 'IncludeController@blockInclude')->name('block_include');
        //Residential Type
        Route::get('/residential_type', 'ResidentialTypeController@index')->name('residential_type');
        Route::get('/add_residential_type', 'ResidentialTypeController@create')->name('add_residential_type');
        Route::post('/add_residential_type', 'ResidentialTypeController@store')->name('store_residential_type');
        Route::get('/show_residential_type/{id}', 'ResidentialTypeController@show')->name('show_residential_type');
        Route::get('/edit_residential_type/{id}', 'ResidentialTypeController@edit')->name('edit_residential_type');
        Route::post('/edit_residential_type/{id}', 'ResidentialTypeController@update')->name('update_residential_type');
        Route::get('/delete_residential_type/{id}', 'ResidentialTypeController@destroy')->name('delete_residential_type');
        Route::get('/block_residential_type', 'ResidentialTypeController@blockResidentialType')->name('block_residential_type');
        //Gallary
        Route::get('/gallaries', 'GallaryController@index')->name('gallaries');
        Route::get('/add_gallary', 'GallaryController@create')->name('add_gallary');
        Route::post('/add_gallary', 'GallaryController@store')->name('store_gallary');
        Route::get('/show_gallary/{id}', 'GallaryController@show')->name('show_gallary');
        Route::get('/edit_gallary/{id}', 'GallaryController@edit')->name('edit_gallary');
        Route::post('/edit_gallary/{id}', 'GallaryController@update')->name('update_gallary');
        Route::get('/delete_gallary/{id}', 'GallaryController@destroy')->name('delete_gallary');
        Route::get('/block_gallary', 'GallaryController@blockgallary')->name('block_gallary');
        Route::get('/background_gallary', 'GallaryController@backgroundgallary')->name('background_gallary');

        //info
        Route::get('/information', 'InformationController@edit')->name('show_information');
        Route::post('/information', 'InformationController@update')->name('update_information');

        //Terms
        Route::get('/termconditions', 'TermConditionController@index')->name('termconditions');
        Route::get('/add_term', 'TermConditionController@create')->name('add_term');
        Route::post('/add_term', 'TermConditionController@store')->name('store_term');
        Route::get('/show_term/{id}', 'TermConditionController@show')->name('show_term');
        Route::get('/edit_term/{id}', 'TermConditionController@edit')->name('edit_term');
        Route::post('/edit_term/{id}', 'TermConditionController@update')->name('update_term');
        Route::get('/delete_term/{id}', 'TermConditionController@destroy')->name('delete_term');
        Route::get('/block_term', 'TermConditionController@blockterm')->name('block_term');
        //Country
        Route::get('/countries', 'CountryController@index')->name('countries');
        Route::get('/add_country', 'CountryController@create')->name('add_country');
        Route::post('/add_country', 'CountryController@store')->name('store_country');
        Route::get('/show_country/{id}', 'CountryController@show')->name('show_country');
        Route::get('/edit_country/{id}', 'CountryController@edit')->name('edit_country');
        Route::post('/edit_country/{id}', 'CountryController@update')->name('update_country');
        Route::get('/delete_country/{id}', 'CountryController@destroy')->name('delete_country');
        Route::get('/block_country', 'CountryController@blockCountry')->name('block_country');
        //City
        Route::get('/cities', 'CityController@index')->name('cities');
        Route::get('/add_city', 'CityController@create')->name('add_city');
        Route::post('/add_city', 'CityController@store')->name('store_city');
        Route::get('/show_city/{id}', 'CityController@show')->name('show_city');
        Route::get('/edit_city/{id}', 'CityController@edit')->name('edit_city');
        Route::post('/edit_city/{id}', 'CityController@update')->name('update_city');
        Route::get('/delete_city/{id}', 'CityController@destroy')->name('delete_city');
        Route::get('/block_city', 'CityController@blockCity')->name('block_city');
        //Reason
        Route::get('/reasons', 'ReasonController@index')->name('reasons');
        Route::get('/add_reason', 'ReasonController@create')->name('add_reason');
        Route::post('/add_reason', 'ReasonController@store')->name('store_reason');
        Route::get('/show_reason/{id}', 'ReasonController@show')->name('show_reason');
        Route::get('/edit_reason/{id}', 'ReasonController@edit')->name('edit_reason');
        Route::post('/edit_reason/{id}', 'ReasonController@update')->name('update_reason');
        Route::get('/delete_reason/{id}', 'ReasonController@destroy')->name('delete_reason');
        Route::get('/block_reason', 'ReasonController@blockReason')->name('block_reason');
        //Property List
        Route::get('/properties', 'PropertyListController@index')->name('properties');
        Route::get('/show_property/{id}', 'PropertyListController@show')->name('show_property');
        Route::get('/edit_property/{id}', 'PropertyListController@edit')->name('edit_property');
        Route::post('/edit_property/{id}', 'PropertyListController@update')->name('update_property');
        Route::get('/add_property', 'PropertyListController@create')->name('add_property');
        Route::post('/add_property', 'PropertyListController@store')->name('store_property');
        Route::get('/delete_property/{id}', 'PropertyListController@destroy')->name('delete_property');

        Route::get('/block_property_list', 'PropertyListController@blockPropertyList')->name('block_property_list');
        //Coupon
        Route::get('/coupons', 'CouponController@index')->name('coupons');
        Route::get('/add_coupon', 'CouponController@create')->name('add_coupon');
        Route::post('/add_coupon', 'CouponController@store')->name('store_coupon');
        Route::get('/show_coupon/{id}', 'CouponController@show')->name('show_coupon');
        Route::get('/edit_coupon/{id}', 'CouponController@edit')->name('edit_coupon');
        Route::post('/edit_coupon/{id}', 'CouponController@update')->name('update_coupon');
        Route::get('/delete_coupon/{id}', 'CouponController@destroy')->name('delete_coupon');
        Route::get('/block_coupon', 'CouponController@blockCoupon')->name('block_coupon');
        //Chat
        Route::get('/chat', 'ChatController@index')->name('chat');
        //Reservation
        Route::get('/reservations/{type}', 'ReservationController@index')->name('reservations');
        Route::get('/reservation/{id}', 'ReservationController@show')->name('show_reservation');
        Route::post('/reservation_accept/{id}', 'ReservationController@accept')->name('accept_reservation');
        Route::post('/reservation_reject/{id}', 'ReservationController@reject')->name('reject_reservation');
        Route::post('/reservation_cancel/{id}', 'ReservationController@cancel')->name('cancel_reservation');
        //Administration
        Route::get('/admins', 'AdministrationController@index')->name('admins');
        Route::get('/add_admin', 'AdministrationController@create')->name('add_admin');
        Route::post('/add_admin', 'AdministrationController@store')->name('store_admin');
        Route::get('/show_admin/{id}', 'AdministrationController@show')->name('show_admin');
        Route::get('/edit_admin/{id}', 'AdministrationController@edit')->name('edit_admin');
        Route::post('/edit_admin/{id}', 'AdministrationController@update')->name('update_admin');
        Route::get('/delete_admin/{id}', 'AdministrationController@destroy')->name('delete_admin');
        Route::get('/block_admin', 'AdministrationController@blockAdmin')->name('block_admin');
        //Permission
        Route::get('/permissions', 'PermissionController@index')->name('permissions');
        Route::get('/add_permission', 'PermissionController@create')->name('add_permission');
        Route::post('/add_permission', 'PermissionController@store')->name('store_permission');
        Route::get('/show_permission/{id}', 'PermissionController@show')->name('show_permission');
        Route::get('/edit_permission/{id}', 'PermissionController@edit')->name('edit_permission');
        Route::post('/edit_permission/{id}', 'PermissionController@update')->name('update_permission');
        Route::get('/delete_permission/{id}', 'PermissionController@destroy')->name('delete_permission');
        Route::get('/block_permission', 'PermissionController@blockPermission')->name('block_permission');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
