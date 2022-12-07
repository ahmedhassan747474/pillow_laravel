<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $table = 'rides';

    protected $fillable = [
        'name', 'phone_number', 'phone_code', 'image', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function likes()
    {
        return $this->hasMany('App\RideLike');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
