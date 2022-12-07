<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\City;
use Illuminate\Support\Facades\App;

class AjaxController extends BaseController
{
    public function getCities(Request $request){
    	$city = City::whereStatus('1')->whereCountryId($request->country_id);
        if (App::isLocale('ar')) {
            $city->select('id', 'name_ar as name');
        } else {
            $city->select('id', 'name_en as name');
        }
        $cities = $city->get();

        // $cities = City::whereCountryId($request->country_id)->get();
        return response()->json($cities);
    }
}
