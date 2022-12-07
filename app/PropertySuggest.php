<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertySuggest extends Model
{
    protected $table = 'property_suggest';

    protected $fillable = [
        'suggest', 'property_id', 'user_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
