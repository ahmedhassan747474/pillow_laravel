<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyList extends Model
{
    protected $table = 'property_list';

    protected $fillable = [
        'id', 'name_ar', 'name_en', 'image', 'status','created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function getImageAttribute($value)
    {
        if($value != null)
        {
            return asset('images/property_list/'.$value); //public //true
        } else {
            return null;
        }
        
    }
}
