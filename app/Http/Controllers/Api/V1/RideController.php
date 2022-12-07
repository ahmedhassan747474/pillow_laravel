<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;
use App\Transformers\Api\V1\RideTransformer;
use Illuminate\Support\Facades\Validator;
use App;
use App\Ride;
use App\RideLike;
use App\Review;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class RideController extends Controller
{
    function __construct(RideTransformer $ride_transformer) 
    {
        config(['auth.defaults.guard' => 'api']);
        $this->ride_transformer = $ride_transformer;
        App::setLocale(request()->header('Accept-Language'));
    }

    public function ride(Request $request)
    {
        $rides = Ride::all();

        $rides = $this->ride_transformer->transformCollection($rides);

        return response()->json(['data' => $rides, 'status_code' => 200], 200);
    }

    public function rideDetail(Request $request, $id)
    {
        $ride = Ride::find($id);

    	return response()->json([
    		'data' 			=> $this->ride_transformer->transform($ride), 
    		'status_code' 	=> 200
    	], 200);
    }

    public function rideLike(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
	            'ride_id' 		=> 'required|exists:rides,id',
	            'type'			=> 'required|in:0,1'
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        if($request->type == 1){
	        	RideLike::create([
	        		'ride_id' 		=> $request->ride_id,
	            	'user_id'		=> $user->id
	        	]);
	        } else {
	        	RideLike::where('ride_id', $request->ride_id)->where('user_id', $user->id)->delete();
	        }

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

    public function rideReview(Request $request)
    {
    	$user = $this->getAuthenticatedUser();

        if($user)
        {
            $validator = Validator::make($request->all(), [
            	'rate'			=> 'required|in:1,2,3,4,5',
            	'message'		=> 'nullable|string',
	            'ride_id' 		=> 'required|exists:rides,id',
	        ]);

	        if($validator->fails())
	        {
	            return $this->getErrorMessage($validator);
	        }

	        $now = Carbon::now()->toDateTimeString();

	        $checkRate = Review::where('ride_id', $request->ride_id)->where('user_id', $user->id)->count();

	        if($checkRate > 0) {
	        	return response()->json(['message' => trans('common.you_cannot_rate_again'), 'status_code' => 200], 200);
	        }

        	Review::create([
        		'rate'			=> $request->rate,
    			'message'		=> $request->message,
        		'ride_id' 		=> $request->ride_id,
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
}
