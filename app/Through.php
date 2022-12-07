<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Through extends Model
{
    protected $table = 'throughs';

    protected $fillable = [
        'name_ar', 'name_en', 'type', 'status', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];
}
