<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';

    protected $fillable = [
        'name_ar', 'name_en', 'flag', 'code' , 'latitude', 'longitude', 'time_zone',
        'co_map_image', 'mobile_pattern', 'mobile_format', 'status'
    ];

    protected $hidden = ['created_at','updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at', 'deleted_at'];

    public function getFlagAttribute($value)
    {
        if($value != null)
        {
            return asset('images/countries/'.$value); //public //true
        } else {
            return null;
        }
        
    }
    
    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
