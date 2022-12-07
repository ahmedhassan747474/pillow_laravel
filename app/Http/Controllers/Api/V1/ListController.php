<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\Api\V1\RideTransformer;
use App;
use App\Country;
use App\City;
use App\BookList;
use App\IncludeList;
use App\ResidentialType;
use App\Through;
use App\PaymentMethod;
use App\Reason;
use App\Ride;

class ListController extends Controller
{
    function __construct(RideTransformer $ride_transformer) 
    {
        App::setLocale(request()->header('Accept-Language'));
        // date_default_timezone_set('Asia/Riyadh');
        ini_set( 'serialize_precision', -1 );
        $this->ride_transformer = $ride_transformer;
    }

    public function countries(Request $request)
    {
    	$countries = Country::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$countries->select('id', 'name_ar as name', 'flag', 'code', 'latitude', 'longitude');
    	} else {
			$countries->select('id', 'name_en as name', 'flag', 'code', 'latitude', 'longitude');
    	}
    	$results = $countries->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function cities(Request $request)
    {
    	$cities = City::whereStatus('1')->whereCountryId($request->country_id);
    	if ($request->header('Accept-Language') == 'ar') {
    		$cities->select('id', 'name_ar as name');
    	} else {
			$cities->select('id', 'name_en as name');
    	}
    	$results = $cities->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function bookList(Request $request)
    {
    	$books = BookList::whereStatus('1')->whereType($request->type);
    	if ($request->header('Accept-Language') == 'ar') {
    		$books->select('id', 'name_ar as name');
    	} else {
			$books->select('id', 'name_en as name');
    	}
    	$results = $books->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function includeList(Request $request)
    {
    	$includes = IncludeList::whereStatus('1')->whereType('2');//->whereType($request->type);
    	if ($request->header('Accept-Language') == 'ar') {
    		$includes->select('id', 'name_ar as name');
    	} else {
			$includes->select('id', 'name_en as name');
    	}
    	$results = $includes->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function residentailType(Request $request)
    {
    	$residentails = ResidentialType::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$residentails->select('id', 'name_ar as name');
    	} else {
			$residentails->select('id', 'name_en as name');
    	}
    	$results = $residentails->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function throughs(Request $request)
    {
    	$throughs = Through::whereStatus('1')->whereType($request->type);
    	if ($request->header('Accept-Language') == 'ar') {
    		$throughs->select('id', 'name_ar as name');
    	} else {
			$throughs->select('id', 'name_en as name');
    	}
    	$results = $throughs->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function paymentMethod(Request $request)
    {
    	$methods = PaymentMethod::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$methods->select('id', 'name_ar as name');
    	} else {
			$methods->select('id', 'name_en as name');
    	}
    	$results = $methods->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

    public function reason(Request $request)
    {
    	$reasons = Reason::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$reasons->select('id', 'name_ar as name');
    	} else {
			$reasons->select('id', 'name_en as name');
    	}
    	$results = $reasons->get();

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }

	public function all(Request $request)
    {
		$results = array();
    	$includes = IncludeList::whereStatus('1')->whereType('2');
    	if ($request->header('Accept-Language') == 'ar') {
    		$includes->select('id', 'name_ar as name');
    	} else {
			$includes->select('id', 'name_en as name');
    	}
    	$results['includes'] = $includes->get();

		$residentails = ResidentialType::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$residentails->select('id', 'name_ar as name');
    	} else {
			$residentails->select('id', 'name_en as name');
    	}
    	$results['residentails'] = $residentails->get();

		$throughs = Through::whereStatus('1')->whereType($request->type);
    	if ($request->header('Accept-Language') == 'ar') {
    		$throughs->select('id', 'name_ar as name');
    	} else {
			$throughs->select('id', 'name_en as name');
    	}
    	$results['throughs'] = $throughs->get();

		$reasons = Reason::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$reasons->select('id', 'name_ar as name');
    	} else {
			$reasons->select('id', 'name_en as name');
    	}
    	$results['reasons'] = $reasons->get();
    	
    	$books = BookList::whereStatus('1')->whereType($request->book_type);
        if ($request->header('Accept-Language') == 'ar') {
            $books->select('id', 'name_ar as name');
        } else {
            $books->select('id', 'name_en as name');
        }
        $results['books'] = $books->get();
        
        $results['priceMin'] = 0;
        
        $results['priceMax'] = 10000;
        
        $results['priceIncrease'] = 10;

    	return response()->json(['data' => $results, 'status_code' => 200], 200);
    }
}
