<?php

namespace App\Transformers\Admin;

use App\Transformers\Admin\BaseTransformer as Transformer;
use App\Attribute;
use App\AttributeValue;
use Route;

class ReservationTransformer extends Transformer
{
    public function transform($data) : array
    {
        $language = session()->get('back_locale');
        $route_name = Route::getCurrentRoute()->getName();
        ini_set( 'serialize_precision', -1 );

        return [];
        // $return = [
        //     'id' 				    => $data->id,
        //     'user_id'               => $data->user_id,
        //     'user_name'             => $data->user->name ?? '',
        //     'user_email'            => $data->user->email ?? '',
        //     'user_phone_code'       => $data->user->phone_code ?? '',
        //     'user_phone_number'     => $data->user->phone_number?? '',
        //     'property_id'           => $data->property_id,
        //     'property_name'         => $language == 'ar' ? $data->property->name_ar : $data->property->name_en,
        //     'property_country_id'   => $data->property->country_id,
        //     'property_country_name' => $language == 'ar' ? $data->property->country->name_ar : $data->property->country->name_en,
        //     'property_city_id'      => $data->property->city_id,
        //     'property_city_name'    => $language == 'ar' ? $data->property->city->name_ar : $data->property->city->name_en,
        //     'property_type'         => $data->property->type,
        //     'property_status'       => $data->property->status,
        //     'property_latitude'     => $data->property->latitude,
        //     'property_longitude'    => $data->property->longitude,
        //     'property_description'  => $language == 'ar' ? $data->property->description_ar : $data->property->description_en,
        //     'sub_price'             => $data->sub_price,
        //     'coupon_name'           => $data->coupon_name,
        //     'coupon_type'           => $data->coupon_type,
        //     'final_price'           => $data->final_price,
        //     'payment_id'            => $data->payment_id,
        //     'payment_name'          => $language == 'ar' ? $data->payment->name_ar : $data->payment->name_en,
        //     'card_number'           => $data->card_number,
        //     'card_name'             => $data->card_name,
        //     'card_cvv'              => $data->card_cvv,
        //     'card_expired_date'     => $data->card_expired_date,
        //     'transaction_id'        => $data->transaction_id,
        //     'status'                => $data->status,
        //     'status_name'           => $this->getStatusName($data->status),
        //     'reason_id'             => $data->reason_id,
        //     'reason_name'           => $data->reason != null ? ($language == 'ar' ? $data->reason->name_ar : $data->reason->name_en) : null,
        //     'other_reason'          => $data->other_reason,
        //     'created_at'            => $data->created_at
        // ];

        return $return;
    }

    private function getStatusName($data)
    {
        //1 = Pending, 2 = Accept, 3 = Reject, 4 = Cancel
        $language = session()->get('back_locale');

        if($language == 'ar') {
            if($data == '1'){
                $status_name = 'قيد الانتظار';
            } elseif($data == '2') {
                $status_name = 'مقبول';
            } elseif($data == '3') {
                $status_name = 'مرفوض';
            } else {
                $status_name = 'ألغيت';
            }
        } else {
            if($data == '1'){
                $status_name = 'Pending';
            } elseif($data == '2') {
                $status_name = 'Accepted';
            } elseif($data == '3') {
                $status_name = 'Rejected';
            } else {
                $status_name = 'Canceled';
            }
        }

        return $status_name;
    }

}
