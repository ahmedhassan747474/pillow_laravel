<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class myGallary extends Model
{
    protected $table = 'gallaries';

    protected $fillable = [
        'name', 'background', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];


}
