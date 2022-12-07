<?php

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'], function(){

    //Auth
        Route::post('sign_in', 'UserController@login');
        Route::post('sign_up', 'UserController@registration');
        Route::post('forget_password', 'UserController@forgetPassword');
        Route::post('change_password', 'UserController@changePassword');
        Route::post('sign_with_social', 'UserController@loginWithSocial');
        Route::post('active_phone_number', 'UserController@verifyPhoneNumber');
Route::get('/getupdates', function(){    return response()->json(['num'=>1, "ios"=>"sss", 'android'=>"sss"]);
    dd( $categories);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://taxes.like4app.com/online/categories",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'deviceId' => '5b3e7f9bfb09c2a60d835794282f589d2fc4bfa89cc093c574ee76126dbc0b86',
                'email' => 'Jaber2800@hotmail.com',
                'password' => 'c0bf116b36be1ec7d90bf6a520c1c350',
                'securityCode' => '9a328e9f300dfd45f54e48c12df75363',
                'langId' => $language_id,
                // 'ids[]' => '693'
            ),
            CURLOPT_HTTPHEADER => array(
                // "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
        
        
        do{             
            $response = curl_exec($curl);
        }while(!$response);
        
        
        curl_close($curl);
        $categories = json_decode($response);
dd( $categories);
    return response()->json(['num'=>1, "ios"=>"sss", 'android'=>"sss"]);
});

    //like card
	Route::post('/get_like_card_categories', 'LikeCardController@categories');
	Route::post('/search', 'LikeCardController@search');
	Route::post('/products', 'LikeCardController@products');
    //Lists
        Route::get('list_of_countries', 'ListController@countries');
        Route::get('list_of_cities', 'ListController@cities');
        Route::get('list_of_book_list', 'ListController@bookList');
        Route::get('list_of_includes', 'ListController@includeList');
        Route::get('list_of_residentials', 'ListController@residentailType');
        Route::get('list_of_throughs', 'ListController@throughs');
        Route::get('list_of_payments', 'ListController@paymentMethod');
        Route::get('list_of_reasons', 'ListController@reason');
        Route::get('list_of_all', 'ListController@all');

    //Home
        Route::get('list_of_ownerProperties', 'PropertyController@ListOfOwnerProperties');

        Route::get('list_of_property_type', 'PropertyController@listOfPropertyType');
        Route::get('home_property', 'PropertyController@homePage')->name('home_property');
        Route::get('list_of_property', 'PropertyController@ListOfProperty');
        Route::get('list_of_property/{type}', 'PropertyController@ListOfPropertyByType');
        Route::get('list_of_most_property', 'PropertyController@ListOfMostProperty');
        Route::get('property_detail/{id}', 'PropertyController@propertyDetail')->name('property_detail');
        Route::get('property_room/{id}', 'PropertyController@propertyRoom')->name('property_room');
        Route::Post('property_filter', 'PropertyController@propertyFilter');

        Route::get('type_of_residential', 'PropertyController@typeResidential');
        Route::get('home_residential', 'PropertyController@homePageResidential')->name('home_residential');
        Route::get('list_of_residential', 'PropertyController@ListOfResidential');
        Route::get('list_of_most_residential', 'PropertyController@ListOfMostResidential');

        Route::get('list_of_favourite', 'PropertyController@ListOfPropertyFavourite');

    //Rides
        Route::get('list_of_rides', 'RideController@ride');
        Route::get('ride_detail/{id}', 'RideController@rideDetail')->name('ride_detail');

    Route::group(['middleware' => 'user'], function(){
        //Auth
        Route::post('update_profile', 'UserController@updateProfile');
        Route::post('logout', 'UserController@logout');
        Route::get('get_profile', 'UserController@getProfile');
        Route::post('send_active_email', 'UserController@sendActiveEmail');
        //Property
            Route::Post('property_favourite', 'PropertyController@propertyFavourite');
            Route::Post('property_suggest', 'PropertyController@propertySuggest');
            Route::Post('property_rate', 'PropertyController@propertyRate');
            Route::Post('check_coupon', 'PropertyController@checkCoupon');


            Route::get('get_special_properties', 'PropertyController@getSpecialProperites');

            Route::Post('add_property', 'PropertyController@addProperty');
            Route::Post('update_property/{id}', 'PropertyController@updateProperty');
            Route::get('get_property_owner', 'PropertyController@getPropertyOwner');
            Route::get('search_property', 'PropertyController@searchProperty');
            Route::GET('search_property_nearby', 'PropertyController@searchPropertyNearby');
            Route::Post('add_gallaries', 'PropertyController@addGallaries');
            Route::GET('get_gallaries', 'PropertyController@getGallaries');
            Route::GET('get_terms', 'PropertyController@getTerms');

            //info
            Route::GET('get_information', 'PropertyController@getInformation');

            Route::GET('get_attribute', 'PropertyController@getAttribute');

            //offers
            Route::post('add_offer', 'OfferController@addOffer');
            Route::get('get_offer', 'OfferController@getOffer');
            Route::post('change_status', 'OfferController@changeStatus');
            Route::get('delete_offer', 'OfferController@deleteOffer');

        //Property Reservation
            Route::Post('property_reserve', 'PropertyController@propertyReserve');
            Route::Post('property_reserve_history', 'PropertyController@propertyReserveHistory');
            Route::Post('property_reserve_cancel', 'PropertyController@propertyReserveCancel');
        //Ride
            Route::Post('ride_like', 'RideController@rideLike');
            Route::Post('ride_review', 'RideController@rideReview');
        //Chat
            Route::post('get_chat', 'ChatController@getChatMessages');
            Route::post('send_message', 'ChatController@sendMessage');
    });
});
