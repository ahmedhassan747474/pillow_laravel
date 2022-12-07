<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class,'property_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id');
    }
}
