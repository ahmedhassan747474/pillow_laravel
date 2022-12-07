<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'surename', 'phone_code', 'phone_number', 'image',
        'email_activate', 'change_email', 'active_email_token', 'phone_code', 'phone_number',
        'token', 'provider_google_id', 'provider_facebook_id', 'provider_twitter_id',
        'change_phone_code', 'change_phone_number', 'wallet', 'user_type', 'ride_verified', 'phone_verified','city_id','country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getImageAttribute($value)
    {
        if($value != null)
        {
            return asset('images/users/'.$value); //public //true
        } else {
            return null;
        }

    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }
}
