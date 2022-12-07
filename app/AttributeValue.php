<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_value';

    protected $fillable = [
        'name_ar', 'name_en', 'attribute_id', 'status', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function attribute()
    {
        return $this->belongsTo('App\Attribute', 'attribute_id');
    }
}
