<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_image';

    protected $fillable = [
        'name', 'property_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];

    protected $appends = ['only_name'];

    public function property()
    {
        return $this->belongsTo('App\Property', 'property_id');
    }

    public function getOnlyNameAttribute()
    {
        $img_arr = explode('/', $this->name);
        $imageName = $img_arr[count($img_arr)-1];
        return $imageName;
    }

    public function getNameAttribute($value)
    {
        if($value != null)
        {
            return asset('images/properties/'.$value); //public //true
        } else {
            return null;
        }
    }
    
}
