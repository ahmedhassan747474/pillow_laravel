<?php

namespace App\Transformers\Api\V1;

use App\Transformers\Api\V1\BaseTransformer as Transformer;
use Route;

class RideTransformer extends Transformer
{
    public function transform($data) : array
    {
        $language = request()->header('Accept-Language');
        $route_name = Route::getCurrentRoute()->getName();
        ini_set( 'serialize_precision', -1 );

        $return = [
            'id' 				=> $data->id,
            'name'              => $data->name,
            'phone_code'        => $data->phone_code,
            'phone_number'      => $data->phone_number,
            'image'             => $data->image,
            'likes'             => count($data->likes),
            'comments'          => count($data->reviews),
            'rates'             => $data->reviews->avg('rate') != null ? $data->reviews->avg('rate') : 0
        ];

        if($route_name == 'ride_detail')
        {
            $return['customers']        = 0;
            $return['reviews']          = $this->getReviews($data->reviews);
        }

        return $return;
    }

    private function getReviews($reviews)
    {
        $array = array();
        $index = 0;
        foreach ($reviews as $review) {
            $array[$index]['id']        = $review->id;
            $array[$index]['rate']      = $review->rate;
            $array[$index]['message']   = $review->message;
            $array[$index]['user_id']   = $review->user_id;
            $array[$index]['user_image']= $review->user->image;
            $index++;
        }
        return $array;
    }

}