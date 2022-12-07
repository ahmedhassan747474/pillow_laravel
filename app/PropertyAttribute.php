<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyAttribute extends Model
{
    protected $table = 'property_attribute';

    protected $fillable = [
        'attribute_id', 'property_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Attribute', 'attribute_id');
    }
}
