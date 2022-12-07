<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    protected $table = 'term_conditions';

    protected $fillable = [
        'id', 'name', 'type', 'status','created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];
}
