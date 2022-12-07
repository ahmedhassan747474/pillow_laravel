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
use App\Offer;
use App\ResidentialType;
use App\Through;
use App\PaymentMethod;
use App\Reason;
use App\Ride;
use App\User;
use Illuminate\Support\Facades\Validator;

class OfferController extends BaseController
{
    function __construct(RideTransformer $ride_transformer)
    {
        App::setLocale(request()->header('Accept-Language'));
        // date_default_timezone_set('Asia/Riyadh');
        ini_set( 'serialize_precision', -1 );
        $this->ride_transformer = $ride_transformer;
    }
    public function addOffer(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        // return $request['attributes'];

        if($user)
        {
            $validator = Validator::make($request->all(), [
                'price'       	=> 'required',
                'date_of_visit'       	=> 'required',
                'owner_id'       	=> 'required',
            ]);
            if($validator->fails())
            {
                return $this->getErrorMessage($validator);
            }

            $offer = Offer::create([
                'owner_id'       	=> $request->owner_id,
                'date_of_visit'       	=> $request->date_of_visit,
                'price'       	=> $request->price,
                'user_id'    => $user->id,
                'property_id'    => $request->property_id,
                'commission_negotiate'    => $request->commission_negotiate,
                'commission'       	=> $request->commission,
                'status'       	=> 1,
            ]);

            $owner = User::find($request->owner_id);
            $owner->unseen_offers =$owner->unseen_offers+1;
            $owner->save();
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

    public function getOffer(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        // return $request['attributes'];

        if($user)
        {
            $offer= Offer::where('user_id',$user->id)
                            ->orWhere('owner_id',$user->id)
                            ->orderBy('id','desc')->with('property')->get();

                            $user->unseen_offers=0;
                            $user->save();
            // if($request->owner_id){
            //     $offer->where('owner_id',$request->owner_id);
            // }
            // if($request->user_id){
            //  $offer->where('user_id',$request->user_id);
            //  }
             return response()->json([
                 'data'=>$offer,
                 'status_code' 	=> 200
             ], 200);
        }
        else
        {
            return response()->json(['message' => trans('common.user_not_exist'), 'status_code' => 401], 401);
        }

    }
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id'       	=> 'required',
            'status'       	=> 'required',
        ]);
        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $offer= Offer::find($request->offer_id);

        $offer->status=$request->status;
        $offer->save();

        $owner = User::find($offer->owner_id);
        $owner->unseen_offers =$owner->unseen_offers+1;
        $owner->save();
        return response()->json([
            'data'=>$offer,
            'status_code' 	=> 200
        ], 200);

    }

    public function deleteOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'offer_id'       	=> 'required',
        ]);
        if($validator->fails())
        {
            return $this->getErrorMessage($validator);
        }

        $offer= Offer::find($request->offer_id);

        $offer->delete();
        return response()->json([
            'message'=>trans('common.Deleted Successfully'),
            'status_code' 	=> 200
        ], 200);

    }
}
