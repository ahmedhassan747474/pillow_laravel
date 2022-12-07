<?php

namespace App\Transformers\Api\V1;

use App\Transformers\Api\V1\BaseTransformer as Transformer;
use Route;

class ReservationTransformer extends Transformer
{
    public function transform($data) : array
    {
        $language = request()->header('Accept-Language');
        $route_name = Route::getCurrentRoute()->getName();
        ini_set( 'serialize_precision', -1 );

        $return = [
            'id' 				=> $data->id,
            'property_id'       => $data->property_id,
            'sub_price'         => $data->sub_price,
            'final_price'       => $data->final_price,
            'payment_id'        => $data->payment_id,
            'transaction_id'    => $data->transaction_id,
            'status'            => $data->status,
            'created_at'        => $data->created_at
        ];

        return $return;
    }

}