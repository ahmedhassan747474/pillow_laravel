<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'rate', 'message', 'ride_id', 'user_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function ride()
    {
        return $this->belongsTo('App\Ride', 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
