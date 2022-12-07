<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookList extends Model
{
    protected $table = 'book_list';

    protected $fillable = [
        'name_ar', 'name_en', 'type', 'status', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];
}
