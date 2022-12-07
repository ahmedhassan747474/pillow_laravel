<?php

namespace App\Transformers\Api\V1;

use App\Transformers\Api\V1\BaseTransformer as Transformer;

class UserTransformer extends Transformer
{
    public function transform($data) : array
    {
        ini_set( 'serialize_precision', -1 );

        $language ='ar';
        return [
            'id' 				=> $data->id,
            'name' 				=> $data->name,
            'email' 			=> $data->email,
            'status' 			=> $data->status,
            // 'phone_code'		=> $data->phone_code,
            'phone_number'      => $data->phone_number,
            'image'				=> $data->image,
            'surename'			=> $data->surename,
            'email_activate'	=> $data->email_activate,
            'wallet'            => $data->wallet,
            'unseen_offers'            => $data->unseen_offers,
            'user_type'         => $data->user_type,
            'country_id'        => $data->country_id,
            'country_name'      => $data->country != null ? ($language == 'ar' ? $data->country->name_ar : $data->country->name_en) : null,
            'city_id'           => $data->city_id,
            'city_name'         => $data->city != null ? ($language == 'ar' ? $data->city->name_ar : $data->city->name_en) : null,
            'is_verified'       => $data->is_verified,
            'phone_verified'    => $data->phone_verified
        ];
    }

}
