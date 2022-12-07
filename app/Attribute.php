<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $fillable = [
        'id', 'name_ar', 'name_en', 'type', 'image', 'status','created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function getImageAttribute($value)
    {
        if($value != null)
        {
            return asset('images/attributes/'.$value); //public //true
        } else {
            return null;
        }
    }

    public function values()
    {
        return $this->hasMany('App\AttributeValue');
    }

    public function propertyAttribute()
    {
        return $this->hasMany('App\PropertyAttribute');
    }
}
