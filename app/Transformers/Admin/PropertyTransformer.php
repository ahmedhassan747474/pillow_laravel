<?php

namespace App\Transformers\Admin;

use App\Transformers\Admin\BaseTransformer as Transformer;
use App\Attribute;
use App\AttributeValue;
use Route;

class PropertyTransformer extends Transformer
{
    public function transform($data) : array
    {
        $language = session()->get('back_locale');
        $route_name = Route::getCurrentRoute()->getName();
        ini_set( 'serialize_precision', -1 );

        // $type='';
        // switch($data->type){
        //     case 1 : $type='Apartment';
        //     break;
        //     case 2 : $type='Villa';
        //     break;
        //     case 3 : $type='Administrative';
        //     break;
        //     case 4 : $type='Shop';
        //     break;
        //     case 5 : $type='Chalet';
        //     break;
        //     case 6 : $type='Land';
        //     break;
        //     case 7 : $type='Farms';
        //     break;
        //     case 8 : $type='Factories';
        //     break;
        // }
        $return = [
            'id' 				=> $data->id,
            'name' 				=> $language == 'ar' ? $data->name_ar : $data->name_en,
            'country_id'        => $data->country_id,
            'country_name'      => $data->country != null ? ($language == 'ar' ? $data->country->name_ar : $data->country->name_en) : '',
            'city_id'           => $data->city_id,
            'city_name'         => $data->city != null ? ($language == 'ar' ? $data->city->name_ar : $data->city->name_en) : null,
            'price'             => $data->price,
            'discount'          => $data->discount,
            'discount_type'     => $data->discount_type,
            'after_discount'    => $this->afterDiscount($data->price, $data->discount, $data->discount_type),
            'size'              => $data->size,
            'payment_methods'               => $data->payment_method,
            'is_furnished'       => $data->is_furnished,
            'is_popular'       => $data->is_popular,

            'image'             => $data->propertyImage[0]->name??'',
            'rates'             => $this->getRates($data->propertyRate),
            'type'              => $data->typeData->name_ar??'',
            'status'            => $data->status,
            'latitude'          => $data->latitude,
            'longitude'         => $data->longitude,
            'description'       => $language == 'ar' ? $data->description_ar : $data->description_en,
            'due_date'        => date('Y-m-d', strtotime($data->due_date)),
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

        if ($data->type == '6') {
            $return['book_list_id']      = $data->book_list_id;
            $return['book_list_name']    =$data->bookList->name_ar ??"" ;
            $return['traveler_date']     = date('Y-m-d', strtotime($data->traveler_date));
            $return['traveler_number']   = $data->traveler_number;
            $return['through_id']        = $data->through_id;
            $return['through_name']      = $language == 'ar' ? $data->through->name_ar : $data->through->name_en;
        }

        if ($data->type == '7') {
            $return['book_list_id']      = $data->book_list_id;
            $return['book_list_name']    = $language == 'ar' ? $data->bookList->name_ar : $data->bookList->name_en;
            $return['business_date']     = date('Y-m-d', strtotime($data->business_date));
            $return['num_of_employees']  = $data->num_of_employees;
            $return['include_id']        = $data->include_id;
            $return['include_name']      = $language == 'ar' ? $data->includeList->name_ar : $data->includeList->name_en;
        }

        if ($data->type == '9') {
            $return['through_id']        = $data->through_id;
            $return['through_name']      = $language == 'ar' ? $data->through->name_ar : $data->through->name_en;
            $return['type_id']           = $data->residential_type_id;
            $return['type_name']         = $language == 'ar' ? $data->residentialType->name_ar : $data->residentialType->name_en;
            $return['phone_number']      = $data->phone_number;
            $return['phone_code']        = $data->phone_code;
        }

        if ($data->type == '10') {
            $return['refund']            = $language == 'ar' ? $data->refund_ar : $data->refund_en;
            $return['payment_receipt']   = $language == 'ar' ? $data->payment_receipt_ar : $data->payment_receipt_en;
            $return['include']           = $language == 'ar' ? $data->include_ar : $data->include_en;
            $return['num_of_bed']        = $data->num_of_bed;
        }

        return $return;
    }

    private function getAttributes($data)
    {
        $language = session()->get('back_locale');
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

        $array['rateLocation']  = $rateCount == 0 ? 0 : $rateLocation / $rateCount;
        $array['rateCleaning']  = $rateCount == 0 ? 0 : $rateCleaning / $rateCount;
        $array['rateService']   = $rateCount == 0 ? 0 : $rateService / $rateCount;
        $array['ratePrice']     = $rateCount == 0 ? 0 : $ratePrice / $rateCount;
        $array['rateCount']     = $rateCount;
        $array['rateMix']       = $rateCount == 0 ? 0 : ($rateLocation + $rateCleaning + $rateService + $ratePrice) / ($rateCount * 4);

        return $array;
    }

    private function afterDiscount($price, $discount, $discount_type)
    {
        if($discount != null){
            if ($discount_type == 'percent') {
                return $price - (($price * $discount) / 100);
            } else {
                return $discount + $price;
            }
        } else {
            return null;
        }
    }

}
