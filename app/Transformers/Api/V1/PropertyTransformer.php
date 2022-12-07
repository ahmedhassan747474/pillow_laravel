<?php

namespace App\Transformers\Api\V1;

use App\Transformers\Api\V1\BaseTransformer as Transformer;
use App\Attribute;
use App\Property;
use App\AttributeValue;
use App\PropertyFavourite;
use Illuminate\Support\Facades\Auth;
use Route;

class PropertyTransformer extends Transformer
{
    public function transform($data) : array
    {
        $language = request()->header('Accept-Language');
        $route_name = Route::getCurrentRoute()->getName();
        ini_set( 'serialize_precision', -1 );

        // dd($data->typeData);
        $return = [
            'id' 				=> $data->id,
            'name' 				=> $language == 'ar' ? $data->name_ar : $data->name_en,
            'country_id'        => $data->country_id,
            'country_name'      => $data->country != null ? ($language == 'ar' ? $data->country->name_ar : $data->country->name_en) : null,
            'city_id'           => $data->city_id,
            'city_name'         => $data->city != null ? ($language == 'ar' ? $data->city->name_ar : $data->city->name_en) : null,
            'price'             => $data->price,
            'owner_id'          => $data->owner_id,
            'payment_method'    => $data->payment_method,
            'discount'          => $data->discount,
            'discount_type'     => $data->discount_type,
            'after_discount'    => $this->afterDiscount($data->price, $data->discount, $data->discount_type),
            'size'              => $data->size,
            'per'               => $data->per,
            'is_hot_deal'       => $data->is_hot_deal,
            'is_cheapest'       => $data->is_cheapest,
            'is_popular'        => $data->is_popular,
            'image'             => $data->propertyImage[0]->name??'',
            'rates'             => $this->getRates($data->propertyRate),
            'type'              => $data->type,
            // 'type_name'      => $data->type != null ?  ($language == 'ar' ? $data->typeData->name_ar : $data->typeData->name_en) : null,
            'type_name'      =>  $data->typeData->name_ar ??'',
            'factory_type'              => $data->factory_type,
            'land_type'              => $data->land_type,
            'status'            => $data->status,
            'islike'            => $this->checkLikeProperty($data->propertyFavourite),
            'latitude'          => $data->latitude,
            'longitude'         => $data->longitude,
            'description'       => $language == 'ar' ? $data->description_ar : $data->description_en,
            'start_date'        => date('Y-m-d', strtotime($data->start_date)),
            'end_date'          => date('Y-m-d', strtotime($data->end_date)),
            'num_of_rooms'      => $data->num_of_rooms,
            'num_of_baths'      => $data->num_of_baths,
            'attributes'        => $this->getAttributes($data->propertyAttribute),
            'images'            => $data->propertyImage,
            'book_in'           => date('Y-m-d', strtotime($data->book_in)),
            'start_time'        => date('h:i a', strtotime($data->start_time)),
            'end_time'          => date('h:i a', strtotime($data->end_time)),
            'table_for'         => $data->table_for,
            'child_chair'       => $data->child_chair,
            'guest_number'      => $data->guest_number,
            'hall_size'         => $data->hall_size,
        ];

        if(isset($data->distance)){
            $return['distance']=$data->distance;
        }
        if(Auth::check()){
            $check=PropertyFavourite::where('property_id', $data->id)->where('user_id', auth()->user()->id)->first();
            if($check){
                $return['is_liked']=1;
            }else{
                $return['is_liked']=0;
            }
        }
        if($route_name == 'property_detail')
        {
            $return['description']       = $language == 'ar' ? $data->description_ar : $data->description_en;
            $return['start_date']        = $data->start_date;
            $return['end_date']          = $data->end_date;
            $return['num_of_adult']      = $data->num_of_adult;
            $return['num_of_child']      = $data->num_of_child;
            $return['attributes']        = $this->getAttributes($data->propertyAttribute);
            $return['images']            = $data->propertyImage;
        }

        if($route_name == 'property_room')
        {
            $return['refund']            = $language == 'ar' ? $data->refund_ar : $data->refund_en;
            $return['payment_receipt']   = $language == 'ar' ? $data->payment_receipt_ar : $data->payment_receipt_en;
            $return['include']           = $language == 'ar' ? $data->include_ar : $data->include_en;
            $return['num_of_adult']      = $data->num_of_adult;
            $return['num_of_child']      = $data->num_of_child;
            $return['num_of_bed']        = $data->num_of_bed;
            $return['attributes']        = $this->getAttributes($data->propertyAttribute);
            $return['images']            = $data->propertyImage;
        }

        // if ($data->type == '6') {
            $return['book_list_id']      = $data->book_list_id;
            $return['book_list_name']    = $data->bookList != null ? ( $language == 'ar' ? $data->bookList->name_ar : $data->bookList->name_en) : null;
            $return['traveler_date']     = date('Y-m-d', strtotime($data->traveler_date));
            $return['traveler_number']   = $data->traveler_number;
            $return['through_id']        = $data->through_id;
            $return['through_name']      = $data->through != null ? ($language == 'ar' ? $data->through->name_ar : $data->through->name_en) : null;
        // }

        // if ($data->type == '7') {
            // $return['book_list_id']      = $data->book_list_id;
            // $return['book_list_name']    = $language == 'ar' ? $data->bookList->name_ar : $data->bookList->name_en;
            $return['business_date']     = date('Y-m-d', strtotime($data->business_date));
            $return['num_of_employees']  = $data->num_of_employees;
            $return['include_id']        = $data->include_id;
            $return['include_name']      = $data->includeList != null ? ($language == 'ar' ? $data->includeList->name_ar : $data->includeList->name_en) : null;
        // }

        // if ($data->type == '9') {
            // $return['through_id']        = $data->through_id;
            // $return['through_name']      = $language == 'ar' ? $data->through->name_ar : $data->through->name_en;
            $return['type_id']           = $data->residential_type_id;
            // $return['type_name']         = $data->residentialType != null ? ($language == 'ar' ? $data->residentialType->name_ar : $data->residentialType->name_en) : null;
            $return['phone_number']      = $data->phone_number;
            $return['phone_code']        = $data->phone_code;
        // }

        // if ($data->type == '10') {
            // $return['refund']            = $language == 'ar' ? $data->refund_ar : $data->refund_en;
            $return['payment_receipt']   = $language == 'ar' ? $data->payment_receipt_ar : $data->payment_receipt_en;
            $return['include']           = $language == 'ar' ? $data->include_ar : $data->include_en;
            $return['num_of_bed']        = $data->num_of_bed;
        // }

        return $return;
    }

    private function getAttributes($data)
    {
        $language = request()->header('Accept-Language');
        $attributes = $data;
        $array = array();
        foreach($attributes as $attribute){
            $getDetails = Attribute::whereId($attribute->attribute_id);

            if ($language == 'ar') {
                $getDetails->select('id', 'name_ar as name', 'type' ,'image');
            } else {
                $getDetails->select('id', 'name_en as name', 'type' ,'image');
            }

            $result = $getDetails->first();

            $getValue = AttributeValue::whereAttributeId($result->id);

            if ($language == 'ar') {
                $getValue->select('id', 'name_ar as name');
            } else {
                $getValue->select('id', 'name_en as name');
            }

            $values = $getValue->get();

            $result->values = $values;

            $array[] = $result;
        }

        return $array;
    }

    private function getRates($rates)
    {
        $rateLocation   = null;
        $rateCleaning   = null;
        $rateService    = null;
        $ratePrice      = null;
        $rateCount      = count($rates);

        foreach ($rates as $rate) {
            $rateLocation += $rate->location;
            $rateCleaning += $rate->cleaning;
            $rateService += $rate->service;
            $ratePrice += $rate->price;
        }

        $array = array();

        $array['rateLocation']  = $rateCount != 0 ? $rateLocation / $rateCount : 0;
        $array['rateCleaning']  = $rateCount != 0 ? $rateCleaning / $rateCount : 0;
        $array['rateService']   = $rateCount != 0 ? $rateService / $rateCount : 0;
        $array['ratePrice']     = $rateCount != 0 ? $ratePrice / $rateCount : 0;
        $array['rateCount']     = $rateCount;
        $array['rateMix']       = $rateCount != 0 ? ($rateLocation + $rateCleaning + $rateService + $ratePrice) / ($rateCount * 4) : 0;

        return $array;
    }

    private function checkLikeProperty($likes)
    {
        if(auth('api')->check())
        {
            foreach ($likes as $like) {
                if($like->user_id == auth('api')->user()->id)
                {
                    return 1;
                }
            }
        } else {
            return 0;
        }
    }

    private function afterDiscount($price, $discount, $discount_type)
    {
        if($discount != null){
            if ($discount_type == '1') {
                return ($price * $discount) + $price;
            } else {
                return $discount + $price;
            }
        } else {
            return null;
        }
    }

}
