<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'user_id', 'property_id', 'ride_id', 'sub_price', 'coupon_name', 'coupon_dicount', 
        'coupon_type', 'final_price', 'payment_id', 'card_number', 'card_name', 'card_cvv', 
        'card_expired_date', 'transaction_id', 'status', 'reason_id', 'other_reason', 'type', 
        'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }

    public function ride()
    {
        return $this->belongsTo('App\Ride', 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function payment()
    {
        return $this->belongsTo('App\PaymentMethod', 'payment_id');
    }

    public function reservationHistory()
    {
        return $this->hasMany('App\ReservationHistory');
    }

    public function reason()
    {
        return $this->belongsTo('App\Reason', 'reason_id');
    }
}
