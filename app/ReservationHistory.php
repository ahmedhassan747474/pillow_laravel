<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    protected $table = 'reservation_history';

    protected $fillable = [
        'reservation_id', 'status', 'comment', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function reservation()
    {
        return $this->belongsTo('App\Reservation', 'reservation_id');
    }
}
