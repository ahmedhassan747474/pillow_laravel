<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $table = 'properties';

    protected $guarded=[];
    // protected $fillable = [
    //     'name_ar', 'name_en', 'description_ar' , 'description_en', 'country_id', 'city_id',
    //     'start_date', 'end_date', 'num_of_adult', 'num_of_child', 'latitude', 'longitude',
    //     'price', 'discount', 'discount_type', 'size', 'per' , 'is_hot_deal', 'is_cheapest',
    //     'is_popular', 'book_in', 'start_time', 'end_time', 'table_for', 'child_chair',
    //     'guest_number', 'hall_size', 'book_list_id','traveler_date', 'traveler_number',
    //     'include_id' , 'residential_type_id', 'through_id', 'phone_number', 'phone_code',
    //     'num_of_employees', 'business_date', 'type', 'parent_id', 'refund_ar', 'refund_en',
    //     'payment_receipt_ar', 'payment_receipt_en', 'num_of_bed', 'include_ar', 'include_en',
    //     'status', 'created_at', 'updated_at', 'deleted_at','owner_id'
    // ];

    protected $hidden = ['created_at','updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at', 'deleted_at'];

    // public function getFlagAttribute($value)
    // {
    //     // if($this->flag != null)
    //     // {
    //     //     $this->attributes['flag'] = asset('public/images/countries_images/'.$this->flag);
    //     // }

    //     if($value != null)
    //     {
    //         return asset('public/images/countries_images/'.$value, true);
    //     } else {
    //         return null;
    //     }
    //     // return asset('public/images/countries_images/'.$value, true);
    // }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function typeData()
    {
        return $this->belongsTo(PropertyList::class, 'type');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function bookList()
    {
        return $this->belongsTo('App\BookList', 'book_list_id');
    }

    public function includeList()
    {
        return $this->belongsTo('App\IncludeList', 'include_id');
    }

    public function residentialType()
    {
        return $this->belongsTo('App\ResidentialType', 'residential_type_id');
    }

    public function through()
    {
        return $this->belongsTo('App\Through', 'through_id');
    }

    public function propertyAttribute()
    {
        return $this->hasMany('App\PropertyAttribute');
    }

    public function propertyImage()
    {
        return $this->hasMany('App\PropertyImage');
    }

    public function propertyRate()
    {
        return $this->hasMany('App\PropertyRate');
    }

    public function propertySuggest()
    {
        return $this->hasMany('App\PropertySuggest');
    }

    public function propertyFavourite()
    {
        return $this->hasMany('App\PropertyFavourite');
    }
}
