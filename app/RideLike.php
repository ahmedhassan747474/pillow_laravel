<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideLike extends Model
{
    protected $table = 'ride_like';

    protected $fillable = [
        'ride_id', 'user_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];
}
