<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\Api\V1\PropertyTransformer;
use App\Transformers\Api\V1\ReservationTransformer;
use App\Transformers\Api\V1\RideTransformer;
use Illuminate\Support\Facades\Validator;
use App;
use App\Attribute;
use App\Property;
use App\PropertyList;
use App\PropertyFavourite;
use App\PropertySuggest;
use App\PropertyRate;
use App\Coupon;
use App\Gallary;
use App\Information;
use App\Reservation;
use App\ReservationHistory;
use App\PropertyImage;
use App\PropertyAttribute;
use App\PropertyUser;
use App\Ride;
use App\RideLike;
use App\Review;
use App\ResidentialType;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\myGallary;
use App\TermCondition;
use Illuminate\Support\Facades\DB;
Use Image;
use Illuminate\Support\Facades\File;
class PropertyController extends BaseController
{
    function __construct(PropertyTransformer $property_transformer, ReservationTransformer $reservation_transformer, RideTransformer $ride_transformer)
    {
        config(['auth.defaults.guard' => 'api']);
        $this->property_transformer = $property_transformer;
        $this->reservation_transformer = $reservation_transformer;
        $this->ride_transformer = $ride_transformer;
        App::setLocale(request()->header('Accept-Language'));
    }

    public function listOfPropertyType(Request $request)
    {
        // $propertyType = PropertyList::whereStatus('1')->get();

        $propertyType = PropertyList::whereStatus('1');
    	if ($request->header('Accept-Language') == 'ar') {
    		$propertyType->select('id', 'name_ar as name', 'image');
    	} else {
			$propertyType->select('id', 'name_en as name', 'image');
    	}
    	$results = $propertyType->get();

    	return response()->json([
    		'data' 			=> $results,
    		'status_code' 	=> 200
    	], 200);
    }

    public function homePage(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType($request->type)->orderBy('id', 'desc')->take(10)->get();

        $properties =  $this->property_transformer->transformCollection($properties);

        $popularProperty = Property::whereType($request->type)->whereIsPopular('1')->orderBy('id', 'desc')->take(10)->get();

        $popularProperty =  $this->property_transformer->transformCollection($popularProperty);

    	return response()->json([
    		'data' 			=> $properties,
    		'most_popular' 	=> $popularProperty,
    		'status_code' 	=> 200
    	], 200);
    }

    public function ListOfProperty(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType($request->type)->orderBy('id', 'desc')->paginate($request->limit);
    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
    		'totalCurrent' 	=> $properties->count(),
            'current' 		=> $properties->currentPage(),
            'first' 		=> $properties->firstItem(),
            'last' 			=> $properties->lastPage(),
            'perPage' 		=> $properties->perPage(),
            'nextPage' 		=> $properties->nextPageUrl(),
            'previousPage' 	=> $properties->previousPageUrl(),
            'hasMorePage' 	=> $properties->hasMorePages(),
            'total' 		=> $properties->total(),
    		'status_code' 	=> 200
    	], 200);
    }

	public function ListOfOwnerProperties(Request $request)
    {
		$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
				'limit'	=> 'required|min:1|integer',
				'page'	=> 'required|min:1|integer'
			]);

			if($validator->fails())
			{
				return $this->getErrorMessage($validator);
			}
	        $properties = Property::where('parent_id',$user->id)->orderBy('id', 'desc')->paginate($request->limit);

			return response()->json([
				'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
				'totalCurrent' 	=> $properties->count(),
				'current' 		=> $properties->currentPage(),
				'first' 		=> $properties->firstItem(),
				'last' 			=> $properties->lastPage(),
				'perPage' 		=> $properties->perPage(),
				'nextPage' 		=> $properties->nextPageUrl(),
				'previousPage' 	=> $properties->previousPageUrl(),
				'hasMorePage' 	=> $properties->hasMorePages(),
				'total' 		=> $properties->total(),
				'status_code' 	=> 200
			], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function ListOfMostProperty(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType($request->type)->whereIsPopular('1')->orderBy('id', 'desc')->paginate($request->limit);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
    		'totalCurrent' 	=> $properties->count(),
            'current' 		=> $properties->currentPage(),
            'first' 		=> $properties->firstItem(),
            'last' 			=> $properties->lastPage(),
            'perPage' 		=> $properties->perPage(),
            'nextPage' 		=> $properties->nextPageUrl(),
            'previousPage' 	=> $properties->previousPageUrl(),
            'hasMorePage' 	=> $properties->hasMorePages(),
            'total' 		=> $properties->total(),
    		'status_code' 	=> 200
    	], 200);
    }

	public function typeResidential(Request $request)
    {
		$types = ResidentialType::whereStatus('1')->orderBy('id', 'desc');
    	if ($request->header('Accept-Language') == 'ar') {
    		$types->select('id', 'name_ar as name');
    	} else {
			$types->select('id', 'name_en as name');
    	}
    	$results = $types->get();

		// foreach($results as $result)
		// {
		// 	$properties = Property::whereType('9')->orderBy('id', 'desc')->take(10)->get();

		// 	$properties =  $this->property_transformer->transformCollection($properties);

		// 	$popularProperty = Property::whereType('9')->whereIsPopular('1')->orderBy('id', 'desc')->take(10)->get();

		// 	$popularProperty =  $this->property_transformer->transformCollection($popularProperty);
		// }

    	return response()->json([
    		'data' 			=> $results,
    		'status_code' 	=> 200
    	], 200);
    }

	public function homePageResidential(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType('9')->whereResidentialTypeId($request->type)->orderBy('id', 'desc')->take(10)->get();

        $properties =  $this->property_transformer->transformCollection($properties);

        $popularProperty = Property::whereType('9')->whereResidentialTypeId($request->type)->whereIsPopular('1')->orderBy('id', 'desc')->take(10)->get();

        $popularProperty =  $this->property_transformer->transformCollection($popularProperty);

    	return response()->json([
    		'data' 			=> $properties,
    		'most_popular' 	=> $popularProperty,
    		'status_code' 	=> 200
    	], 200);
    }

	public function ListOfResidential(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType('9')->whereResidentialTypeId($request->type)->orderBy('id', 'desc')->paginate($request->limit);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
    		'totalCurrent' 	=> $properties->count(),
            'current' 		=> $properties->currentPage(),
            'first' 		=> $properties->firstItem(),
            'last' 			=> $properties->lastPage(),
            'perPage' 		=> $properties->perPage(),
            'nextPage' 		=> $properties->nextPageUrl(),
            'previousPage' 	=> $properties->previousPageUrl(),
            'hasMorePage' 	=> $properties->hasMorePages(),
            'total' 		=> $properties->total(),
    		'status_code' 	=> 200
    	], 200);
    }

    public function ListOfMostResidential(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 	=> 'required',
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType('9')->whereResidentialTypeId($request->type)->whereIsPopular('1')->orderBy('id', 'desc')->paginate($request->limit);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
    		'totalCurrent' 	=> $properties->count(),
            'current' 		=> $properties->currentPage(),
            'first' 		=> $properties->firstItem(),
            'last' 			=> $properties->lastPage(),
            'perPage' 		=> $properties->perPage(),
            'nextPage' 		=> $properties->nextPageUrl(),
            'previousPage' 	=> $properties->previousPageUrl(),
            'hasMorePage' 	=> $properties->hasMorePages(),
            'total' 		=> $properties->total(),
    		'status_code' 	=> 200
    	], 200);
    }

    public function propertyDetail(Request $request, $id)
    {
        $property = Property::findOrfail($id);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transform($property),
    		'status_code' 	=> 200
    	], 200);
    }

	public function propertyRoom(Request $request, $id)
    {
		$validator = Validator::make($request->all(), [
            'limit'	=> 'required|min:1|integer',
            'page'	=> 'required|min:1|integer'
        ]);

		if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $properties = Property::whereType('10')->whereParentId($id)->orderBy('id', 'desc')->paginate($request->limit);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
    		'totalCurrent' 	=> $properties->count(),
            'current' 		=> $properties->currentPage(),
            'first' 		=> $properties->firstItem(),
            'last' 			=> $properties->lastPage(),
            'perPage' 		=> $properties->perPage(),
            'nextPage' 		=> $properties->nextPageUrl(),
            'previousPage' 	=> $properties->previousPageUrl(),
            'hasMorePage' 	=> $properties->hasMorePages(),
            'total' 		=> $properties->total(),
    		'status_code' 	=> 200
    	], 200);
    }

    public function propertyFilter(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'type' 				=> 'required',
			'start_time'		=> 'nullable|required_with:end_time|date_format:H:i:s',
			'end_time'			=> 'nullable|required_with:start_time|date_format:H:i:s',
			'country'			=> 'nullable|exists:countries,id',
			'city'			    => 'nullable|exists:cities,id',
			'price'             => 'nullable',
			'size'              => 'nullable',
			'num_of_rooms'      => 'nullable',
			'num_of_baths'      => 'nullable',
			'payment_method'    => 'nullable',
			'is_furnished'		=> 'nullable',
            'search_text' 		=> 'nullable',
            'check_in'			=> 'nullable|date_format:Y-m-d',
            'check_out'			=> 'nullable|date_format:Y-m-d|after:check_in',
            'adult'				=> 'nullable|integer',
            'child'				=> 'nullable|integer',
			'book_in'			=> 'nullable|date_format:Y-m-d',
			'table_for'			=> 'nullable|min:1|integer',
			'child_chair'		=> 'nullable|min:1|integer',
			'guest_number'		=> 'nullable|min:1|integer',
			'hall_size'			=> 'nullable',
			'book_list'			=> 'nullable|exists:book_list,id',
			'traveler_date'		=> 'nullable|date_format:Y-m-d',
			'traveler_number'	=> 'nullable|min:1|integer',
			'through'			=> 'nullable|exists:throughs,id',
			'business_date'     => 'nullable|date_format:Y-m-d',
			'num_of_employees'	=> 'nullable|min:1|integer',
			'include'			=> 'nullable|exists:includes,id',
			'residential_type'	=> 'nullable|exists:residential_type,id',
			'price_from'		=> 'nullable|min:1|integer|lt:price_to|required_with:price_to',
			'price_to'			=> 'nullable|min:1|integer|gt:price_from|required_with:price_from',
            'limit'				=> 'required|min:1|integer',
            'page'				=> 'required|min:1|integer'
        ]);

        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

     	$properties = Property::whereType($request->type);

     	if($request->filled('search_text'))
        {
    		$properties->where(function($query) use ($request) {
    			$query->where('name_ar', 'like', '%'.$request->search_text.'%');
                $query->orWhere('name_en', 'like', '%'.$request->search_text.'%');
                $query->orWhere('description_ar', 'like', '%'.$request->search_text.'%');
                $query->orWhere('description_en', 'like', '%'.$request->search_text.'%');
    		});
        }

        if($request->filled('check_in') && $request->filled('check_out'))
        {
    		$properties->where(function($query) use ($request) {
    			$query->whereDate('start_date', $request->check_in);
    			$query->whereDate('end_date', $request->check_out);
    		});
        }

        if($request->filled('country'))
        {
    		$properties->where('country_id', $request->country);
        }

		if($request->filled('city'))
        {
    		$properties->where('city_id', $request->city);
        }

		if($request->filled('num_of_rooms'))
        {
    		$properties->where('num_of_rooms', '<=', $request->num_of_rooms);
        }

		if($request->filled('num_of_baths'))
        {
    		$properties->where('num_of_baths', '<=', $request->num_of_baths);
        }

        if($request->filled('adult'))
        {
    		$properties->where('num_of_adult', '<=', $request->adult);
        }

        if($request->filled('child'))
        {
    		$properties->where('num_of_child', '<=', $request->child);
        }

		if($request->filled('book_in'))
        {
    		$properties->whereDate('book_in', $request->book_in);
        }

        if($request->filled('start_time')  && $request->filled('end_time'))
        {
            $start_time = Carbon::parse($request->start_time)->toTimeString();
            $end_time = Carbon::parse($request->end_time)->toTimeString();
            $properties->where([['start_time', '>=', $start_time], ['end_time', '<=', $end_time]]);
        }

		if($request->filled('table_for'))
        {
    		$properties->where('table_for', '<=', $request->table_for);
        }

		if($request->filled('child_chair'))
        {
    		$properties->where('child_chair', '<=', $request->child_chair);
        }

		if($request->filled('guest_number'))
        {
    		$properties->where('guest_number', '<=', $request->guest_number);
        }

		if($request->filled('hall_size'))
        {
    		$properties->where('hall_size', '<=', $request->hall_size);
        }

		if($request->filled('book_list'))
        {
    		$properties->where('book_list_id', $request->book_list);
        }

		if($request->filled('traveler_date'))
        {
    		$properties->whereDate('traveler_date', $request->traveler_date);
        }

		if($request->filled('traveler_number'))
        {
    		$properties->where('traveler_number', '<=', $request->traveler_number);
        }

        if($request->filled('business_date'))
        {
            $properties->whereDate('business_date', $request->business_date);
        }

		if($request->filled('num_of_employees'))
        {
    		$properties->where('num_of_employees', '<=', $request->num_of_employees);
        }

		if($request->filled('include'))
        {
    		$properties->where('include_id', $request->include);
        }

		if($request->filled('residential_type'))
        {
    		$properties->where('residential_type_id', $request->residential_type);
        }

		if($request->filled('price_from') && $request->filled('price_to'))
        {
    		$properties->whereBetween('price', [$request->price_from, $request->price_to]);
        }

		if($request->filled('price'))
        {
    		$properties->where('price',$request->price);
        }
		if($request->filled('size'))
        {
    		$properties->where('size',$request->size);
        }
		if($request->filled('payment_method'))
        {
    		$properties->where('payment_method',$request->payment_method);
        }
		if($request->filled('is_furnished'))
        {
    		$properties->where('is_furnished',$request->is_furnished);
        }

        $results = $properties->orderBy('id', 'desc')->paginate($request->limit);

    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($results->getCollection()),
    		'totalCurrent' 	=> $results->count(),
            'current' 		=> $results->currentPage(),
            'first' 		=> $results->firstItem(),
            'last' 			=> $results->lastPage(),
            'perPage' 		=> $results->perPage(),
            'nextPage' 		=> $results->nextPageUrl(),
            'previousPage' 	=> $results->previousPageUrl(),
            'hasMorePage' 	=> $results->hasMorePages(),
            'total' 		=> $results->total(),
    		'status_code' 	=> 200
    	], 200);
    }

    public function propertyFavourite(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
	            'property_id' 	=> 'required|exists:properties,id',
	            'type'			=> 'required|in:0,1'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        if($request->type == 1){
	        	PropertyFavourite::create([
	        		'property_id' 	=> $request->property_id,
	            	'user_id'		=> $user->id
	        	]);
	        } else {
	        	PropertyFavourite::where('property_id', $request->property_id)->where('user_id', $user->id)->delete();
	        }

	        return response()->json([
	        	'message' 		=> trans('common.success_save'),
	        	'status_code' 	=> 200,
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

	public function ListOfPropertyFavourite(Request $request)
    {
		$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
				'limit'	=> 'required|min:1|integer',
				// 'page'	=> 'required|min:1|integer'
			]);

			if($validator->fails())
			{
				return $this->getErrorMessage($validator);
			}

			$properties = Property::orderBy('id', 'desc')
				->whereHas('propertyFavourite', function($query) use ($user) {
					$query->whereUserId($user->id);
				})->get();
				// ->paginate($request->limit);

			return response()->json([
				// 'data' 			=> $this->property_transformer->transformCollection($properties->getCollection()),
				'data' 			=> $this->property_transformer->transformCollection($properties),
				// 'totalCurrent' 	=> $properties->count(),
				// 'current' 		=> $properties->currentPage(),
				// 'first' 		=> $properties->firstItem(),
				// 'last' 			=> $properties->lastPage(),
				// 'perPage' 		=> $properties->perPage(),
				// 'nextPage' 		=> $properties->nextPageUrl(),
				// 'previousPage' 	=> $properties->previousPageUrl(),
				// 'hasMorePage' 	=> $properties->hasMorePages(),
				// 'total' 		=> $properties->total(),
				'status_code' 	=> 200
			], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function propertySuggest(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
	            'suggest'		=> 'required|string',
	            'property_id' 	=> 'required|exists:properties,id'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

        	PropertySuggest::create([
        		'suggest'		=> $request->suggest,
        		'property_id' 	=> $request->property_id,
        	]);

	        return response()->json([
	        	'message' 		=> trans('common.success_save'),
	        	'status_code' 	=> 200
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function propertyRate(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
            	'location'		=> 'required|in:1,2,3,4,5',
            	'cleaning'		=> 'required|in:1,2,3,4,5',
            	'service'		=> 'required|in:1,2,3,4,5',
            	'price'			=> 'required|in:1,2,3,4,5',
	            'message'		=> 'nullable|string',
	            'property_id' 	=> 'required|exists:properties,id'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        $now = Carbon::now()->toDateTimeString();

	        $checkRate = PropertyRate::where('property_id', $request->property_id)->where('user_id', $user->id)->count();

	        if($checkRate > 0) {
	        	return response()->json(['message' => trans('common.you_cannot_rate_again'), 'status_code' => 200], 200);
	        }

        	PropertyRate::create([
        		'location'		=> $request->location,
        		'cleaning'		=> $request->cleaning,
        		'service'		=> $request->service,
        		'price'			=> $request->price,
        		'message'		=> $request->message,
        		'property_id' 	=> $request->property_id,
            	'user_id'		=> $user->id,
            	'created_at'	=> $now
        	]);

	        return response()->json([
	        	'message' 		=> trans('common.success_save'),
	        	'status_code' 	=> 200
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function checkCoupon(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
            	'name'	=> 'required|string',
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        $checkCoupon = Coupon::where('name', $request->name)
		        ->whereStatus('1')
		        ->select('id', 'name', 'discount', 'type', 'status')
		        ->get();

	        if(count($checkCoupon) == 0) {
	        	return response()->json(['message' => trans('common.invalid_coupon'), 'status_code' => 200], 200);
	        }

	        return response()->json([
	        	'data' 			=> $checkCoupon,
	        	'status_code' 	=> 200
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function propertyReserve(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
            	'property_id' 		=> 'required_without:ride_id|exists:properties,id',
                'ride_id'           => 'required_without:property_id|exists:properties,id',
            	'payment_id'		=> 'required|exists:payment_method,id',
            	'coupon_id'			=> 'required|exists:coupons,id',
            	'card_number'		=> 'required_unless:payment_id,!=,3|integer|min:16',
            	'card_name'			=> 'required_unless:payment_id,!=,3|string',
            	'card_cvv'			=> 'required_unless:payment_id,!=,3',
            	'card_expired_date'	=> 'required_unless:payment_id,!=,3',
            	'sub_price'			=> 'required',
            	'final_price'		=> 'required',
				'type'				=> 'required'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        $now = Carbon::now()->toDateTimeString();

	        $property = Property::find($request->property_id);

	        $coupon = Coupon::find($request->coupon_id);

	        if($request->payment_id == 3){
	        	$reserve = Reservation::create([
	        		'user_id' 			=> $user->id,
	        		'property_id'		=> $request->property_id,
                    'ride_id'           => $request->ride_id,
	        		'sub_price'			=> $request->sub_price,
	        		'coupon_name'		=> $coupon->name,
	        		'coupon_dicount'	=> $coupon->discount,
	        		'coupon_type'		=> $coupon->type,
	        		'final_price'		=> $request->final_price,
	        		'payment_id'		=> $request->payment_id,
	        		'created_at'		=> $now
	        	]);
	        } else {
	        	$reserve = Reservation::create([
	        		'user_id' 			=> $user->id,
	        		'property_id'		=> $request->property_id,
                    'ride_id'           => $request->ride_id,
	        		'sub_price'			=> $request->sub_price,
	        		'coupon_name'		=> $coupon->name,
	        		'coupon_dicount'	=> $coupon->discount,
	        		'coupon_type'		=> $coupon->type,
	        		'final_price'		=> $request->final_price,
	        		'payment_id'		=> $request->payment_id,
	        		'card_number'		=> $request->card_number,
	        		'card_name'			=> $request->card_name,
	        		'card_cvv'			=> $request->card_cvv,
	        		'card_expired_date'	=> $request->card_expired_date,
	        		'created_at'		=> $now
	        	]);
	        }

	        $history = ReservationHistory::create([
	        	'reservation_id'		=> $reserve->id,
	        	'status'				=> '1'
	        ]);

	       	return response()->json([
	        	'message' 		=> trans('common.success_save'),
	        	'status_code' 	=> 200
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function propertyReserveHistory(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
        	$validator = Validator::make($request->all(), [
	            'limit'	=> 'required|min:1|integer',
	            'page'	=> 'required|min:1|integer'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        $reservations = Reservation::whereUserId($user->id)->orderBy('id', 'desc')->paginate($request->limit);

	    	return response()->json([
	    		'data' 			=> $this->reservation_transformer->transformCollection($reservations->getCollection()),
	    		'totalCurrent' 	=> $reservations->count(),
	            'current' 		=> $reservations->currentPage(),
	            'first' 		=> $reservations->firstItem(),
	            'last' 			=> $reservations->lastPage(),
	            'perPage' 		=> $reservations->perPage(),
	            'nextPage' 		=> $reservations->nextPageUrl(),
	            'previousPage' 	=> $reservations->previousPageUrl(),
	            'hasMorePage' 	=> $reservations->hasMorePages(),
	            'total' 		=> $reservations->total(),
	    		'status_code' 	=> 200
	    	], 200);
        }
        else
        {
        	return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function propertyReserveCancel(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
	            'reserve_id' 	=> 'required|exists:reservations,id',
                'reason_id'     => 'nullable|exists:reasons,id',
                'other_reason'  => 'nullable'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

        	$cancelReserve = Reservation::whereId($request->reserve_id)
	        	->where('user_id', $user->id)
	        	->update([
                    'status'        => '4',
                    'reason_id'     => $request->reason_id,
                    'other_reason'  => $request->other_reason
                ]);

	        $history = ReservationHistory::create([
	        	'reservation_id'		=> $request->reserve_id,
	        	'status'				=> '4'
	        ]);

            $refund = Reservation::whereId($request->reserve_id)->where('user_id', $user->id)->first();

            $user->wallet = $user->wallet + $refund->final_price;
            $user->save();

	        return response()->json([
	        	'message' 		=> trans('common.success_cancel'),
	        	'status_code' 	=> 200
	        ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    //---------------------------
    public function addProperty(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        // return $request['attributes'];

        if($user)
        {
            // $validator = Validator::make($request->all(), [
            //     'name_en'       	=> 'required|string',
            //     'name_ar'       	=> 'required|string',
            //     'description_en'    => 'required|string',
            //     'description_ar'    => 'required|string',
            //     'country_id'       	=> 'required|exists:countries,id',
            //     'city_id'       		=> 'required|exists:cities,id',
            //     'images'         	=> 'required|array',
            //     'is_furnished'		=> 'nullable',
            //     'is_cheapest'		=> 'nullable',
            //     'is_popular'		    => 'nullable',
            //     'attributes'        => 'required|array',
            //     'start_date'        => 'required|date_format:Y-m-d|after:today',
            //     'end_date'        	=> 'required|date_format:Y-m-d|after:start_date',
            //     'latitude'         	=> 'required',
            //     'longitude'         => 'required',
            //     'price'      		=> 'required',
            //     'discount'			=> 'nullable',
            //     'discount_type'		=> 'nullable|in:percent,price',
            //     'size'				=> 'required',
            //     'per'				=> 'required'
            // ]);
            // if($validator->fails())
            // {
            //     return $this->getErrorMessage($validator);
            // }

            $now = Carbon::now()->toDateTimeString();
            $hotel = Property::create([
                'name_en'       	=> $request->name_en,
                'name_ar'       	=> $request->name_ar,
                'owner_id'       	=> $user->id,
                'description_en'    => $request->description_en,
                'description_ar'    => $request->description_ar,
                'country_id'       	=> $request->country_id,
                'city_id'       	=> $request->city_id,
                'num_of_rooms'       	=> $request->num_of_rooms,
                'num_of_baths'       	=> $request->num_of_baths,
                'due_date'        => $request->due_date,
                'end_date'        	=> $request->end_date,
                'latitude'         	=> $request->latitude,
                'longitude'         => $request->longitude,
                'price'      		=> $request->price,
                'discount'			=> $request->discount,
                'discount_type'		=> $request->discount_type,
                'size'				=> $request->size,
                'payment_method'	=> $request->payment_method,
                'is_furnished'       => $request->is_furnished == '1' ? '1' : '0',
                'is_cheapest'       => $request->is_cheapest == '1' ? '1' : '0',
                'is_popular'        => $request->is_popular == '1' ? '1' : '0',
                'type'				=> $request->type,
                'factory_type'				=> $request->factory_type,
                'land_type'				=> $request->land_type,
                'status'			=> 1,
                'selling_status'			=> $request->selling_status,
                'created_at'		=> $now
            ]);

            // dd($request->images);
            if($request->has('images')){
                foreach ($request->images as $image) {
                    $extension      = $image->getClientOriginalExtension();
                    $imageRename    = time(). uniqid() . '.'.$extension;

                    $path           = public_path("images\properties");

                    if(!File::exists($path)) File::makeDirectory($path, 775, true);

                    $img = Image::make($image)->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save('images/properties/'.$imageRename);

                    $hotelImage = PropertyImage::create([
                        'name' 			=> $imageRename,
                        'property_id'	=> $hotel->id
                    ]);
                }
            }

            if($request['attributes']){
                foreach ($request['attributes'] as $key => $value)
                {
                    $hotelAttribute = PropertyAttribute::create([
                        'attribute_id'      => $value,
                        'property_id'       => $hotel->id
                    ]);
                }
            }

            return response()->json([
                'message' 		=> trans('common.success_save'),
                'status_code' 	=> 200,
                'data'          =>$this->property_transformer->transform($hotel)
            ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    //---------------------------
    public function updateProperty(Request $request,$id)
    {
        $user = $this->getAuthenticatedUser();

        // return $request['attributes'];

        if($user)
        {
            // $validator = Validator::make($request->all(), [
            //     'name_en'       	=> 'required|string',
            //     'name_ar'       	=> 'required|string',
            //     'description_en'    => 'required|string',
            //     'description_ar'    => 'required|string',
            //     'country_id'       	=> 'required|exists:countries,id',
            //     'city_id'       		=> 'required|exists:cities,id',
            //     // 'images'         	=> 'required|array',
            //     'is_furnished'		=> 'nullable',
            //     'is_cheapest'		=> 'nullable',
            //     'is_popular'		=> 'nullable',
            //     'attributes'        => 'required|array',
            //     'start_date'        => 'required|date_format:Y-m-d|after:today',
            //     'end_date'        	=> 'required|date_format:Y-m-d|after:start_date',
            //     'latitude'         	=> 'required',
            //     'longitude'         => 'required',
            //     'price'      		=> 'required',
            //     'discount'			=> 'nullable',
            //     'discount_type'		=> 'nullable|in:percent,price',
            //     'size'				=> 'required',
            //     'per'				=> 'required'
            // ]);
            // if($validator->fails())
            // {
            //     return $this->getErrorMessage($validator);
            // }

            $now = Carbon::now()->toDateTimeString();
            $hotel = Property::find($id);
            if(empty($hotel)){
                return response()->json(['message'=>'Property not exist'],401);
            }

            $request_data=$request->except('images','attributes');
            $hotel->update($request_data);
            // $hotel->update([
            //     'name_en'       	=> $request->name_en,
            //     'name_ar'       	=> $request->name_ar,
            //     'owner_id'       	=> $user->id,
            //     'description_en'    => $request->description_en,
            //     'description_ar'    => $request->description_ar,
            //     'country_id'       	=> $request->country_id,
            //     'city_id'       	=> $request->city_id,
            //     'num_of_rooms'       	=> $request->num_of_rooms,
            //     'num_of_baths'       	=> $request->num_of_baths,
            //     'due_date'        => $request->due_date,
            //     'end_date'        	=> $request->end_date,
            //     'latitude'         	=> $request->latitude,
            //     'longitude'         => $request->longitude,
            //     'price'      		=> $request->price,
            //     'discount'			=> $request->discount,
            //     'discount_type'		=> $request->discount_type,
            //     'size'				=> $request->size,
            //     'payment_method'	=> $request->payment_method,
            //     'is_furnished'       => $request->is_furnished == '1' ? '1' : '0',
            //     'is_cheapest'       => $request->is_cheapest == '1' ? '1' : '0',
            //     'is_popular'        => $request->is_popular == '1' ? '1' : '0',
            //     'type'				=> $request->type,
            //     'factory_type'				=> $request->factory_type,
            //     'land_type'				=> $request->land_type,
            //     'status'			=> $request->selling_status,
            //     'created_at'		=> $now
            // ]);

            // dd($request->images);
            if($request->has('images')){
                PropertyImage::where('property_id',$hotel->id)->delete();
                foreach ($request->images as $image) {
                    $extension      = $image->getClientOriginalExtension();
                    $imageRename    = time(). uniqid() . '.'.$extension;

                    $path           = public_path("images\properties");

                    if(!File::exists($path)) File::makeDirectory($path, 775, true);

                    $img = Image::make($image)->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save('images/properties/'.$imageRename);

                    $hotelImage = PropertyImage::create([
                        'name' 			=> $imageRename,
                        'property_id'	=> $hotel->id
                    ]);
                }
            }

            if($request['attributes']){
                PropertyAttribute::where('property_id',$hotel->id)->delete();
                foreach ($request['attributes'] as $key => $value)
                {
                    $hotelAttribute = PropertyAttribute::create([
                        'attribute_id'      => $value,
                        'property_id'       => $hotel->id
                    ]);
                }
            }

            return response()->json([
                'message' 		=> trans('common.success_save'),
                'data'          => $this->property_transformer->transform($hotel),
                'status_code' 	=> 200
            ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }
    }

    public function getPropertyOwner(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        // return $request['attributes'];

        if($user)
        {
            $property = Property::where('owner_id', $user->id)
                                ->get();

            return response()->json([
                'data' 			=> $this->property_transformer->transformCollection($property),
                'status_code' 	=> 200
            ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }

    }

    public function getSpecialProperites()
    {
            $property = Property::where('is_popular', '1')
                                ->get();

            return response()->json([
                'data' 			=> $this->property_transformer->transformCollection($property),
                'status_code' 	=> 200
            ], 200);
    }

    // public function searchProperty(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'latitude'       => 'required|exists:properties,latitude',
    //         'longitude'      => 'required|exists:properties,longitude',
    //     ]);
    //     if($validator->fails())
    //     {
    //         return $this->getErrorMessage($validator);
    //     }

    //     $property = Property::where('latitude', $request->latitude)
    //                         ->where('longitude', $request->longitude)
    //                         ->first();

    // 	return response()->json([
    // 		'data' 			=> $this->property_transformer->transform($property),
    // 		'status_code' 	=> 200
    // 	], 200);
    // }

    public function searchProperty(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'latitude'       => 'required|exists:properties,latitude',
        //     'longitude'      => 'required|exists:properties,longitude',
        // ]);
        // if($validator->fails())
        // {
        //     return $this->getErrorMessage($validator);
        // }

        $property = Property::orderBy('id','desc')->with('propertyAttribute');

        if($request->search){
            $property->where('name_en','like','%'.$request->search.'%')
                        ->orWhere('name_ar','like','%'.$request->search.'%')
                        ->orWhere('price','like','%'.$request->search.'%')
                        ->orWhere('payment_method','like','%'.$request->search.'%')
                        ->orWhere('description_ar','like','%'.$request->search.'%')
                        ->orWhere('description_en','like','%'.$request->search.'%')
                        ->orWhereHas('city',function($q) use($request){
                            $q->where('name_ar','like','%'.$request->search.'%');
                            $q->orWhere('name_en','like','%'.$request->search.'%');
                        })->orWhereHas('country',function($q) use($request){
                            $q->where('name_ar','like','%'.$request->search.'%');
                            $q->orWhere('name_en','like','%'.$request->search.'%');
                        });
        }
        if($request->country_id){
            $property->where('country_id',$request->country_id);
        }

        if($request->city_id){
            $property->where('city_id',$request->city_id);
        }
        if($request->type){
            $property->where('type',$request->type);
        }

        if($request->num_of_rooms){
            $property->where('num_of_rooms',$request->num_of_rooms);
        }

        if($request->num_of_baths){
            $property->where('num_of_baths',$request->num_of_baths);
        }

        if($request->size){
            $property->where('size',$request->size);
        }

        if($request->price){
            $property->where('price',$request->price);
        }

        if($request->payment_method){
            $property->where('payment_method',$request->payment_method);
        }

        if($request->is_furnished){
            $property->where('is_furnished',$request->is_furnished);
        }

        if($request->due_date){
            $property->where('due_date',$request->due_date);
        }

        // dd($request->attributes_ids);
        if($request->attributes_ids){
            $property->whereHas('propertyAttribute',function($q) use($request){
                $q->whereIn('attribute_id',$request->attributes_ids);
            });
        }

        // dd($property->get()[0]->propertyAttribute);
    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($property->get()),
    		'status_code' 	=> 200
    	], 200);
    }

    public function searchPropertyNearby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'       => 'required',
            'longitude'      => 'required',
        ]);
        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        // $property = Property::where('latitude', $request->latitude)
        //                     ->where('longitude', $request->longitude)
        //                     ->first();

        // $property = Pro
        $property= Property::select("*", DB::raw("6371 * acos(cos(radians(" . $request->latitude . "))
                                * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $request->longitude . "))
                                + sin(radians(" .$request->latitude. ")) * sin(radians(latitude))) AS distance"));
        $property          =       $property->having('distance', '<', $request->distance??100000);
        $property          =       $property->orderBy('distance', 'asc');

        $property          =       $property->get();
        $property          =       Property::all();
        return 'AAAAAAAAAAAAAAAAA';
    	return response()->json([
    		'data' 			=> $this->property_transformer->transformCollection($property),
    		'status_code' 	=> 200
    	], 200);
    }
    //admin
    //---------------------------
    public function addGallaries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images'         	=> 'required|array',
        ]);
        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        if($request->has('images')){
            foreach ($request->images as $image) {
                $extension      = $image->getClientOriginalExtension();
                $imageRename    = time(). uniqid() . '.'.$extension;

                $path           = public_path("images\gallary");

                if(!File::exists($path)) File::makeDirectory($path, 775, true);

                $img = Image::make($image)->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save('images/gallary/'.$imageRename);

                $hotelImage = Gallary::create([
                    'name' 			=> $imageRename,
                ]);
            }
        }

            return response()->json([
                'message' 		=> trans('common.success_save'),
                'status_code' 	=> 200
            ], 200);

    }
    public function getGallaries()
    {
        $gallaries = myGallary::where('background', 1)->where('status', 1)->get();

    	return response()->json([
    		'data' 			=> $gallaries,
    		'status_code' 	=> 200
    	], 200);
    }

    public function getTerms()
    {
        $term = TermCondition::where('status', '1')->get();

    	return response()->json([
    		'data' 			=> $term,
    		'status_code' 	=> 200
    	], 200);
    }

    public function getInformation()
    {
        $information = Information::first();

    	return response()->json([
    		'data' 			=> $information,
    		'status_code' 	=> 200
    	], 200);
    }

    public function getAttribute()
    {
        $attribute = Attribute::get();

    	return response()->json([
    		'data' 			=> $attribute,
    		'status_code' 	=> 200
    	], 200);
    }


}
