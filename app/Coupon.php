<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $table = 'coupons';

    protected $fillable = [
        'name', 'discount', 'type', 'status', 'created_at', 'updated_at',
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

}
