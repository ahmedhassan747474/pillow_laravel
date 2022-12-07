<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Chat extends Model
{
    protected $table = 'chat';

    protected $fillable = [
        'sender', 'receiver', 'for_whom', 'created_at', 'updated_at'
    ];

    protected $hidden = ['updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'sender');
    }

    public function messages()
    {
        return $this->hasMany('App\ChatMessage');
    }

    // public function getMessageAttribute($value)
    // {
    //     if($this->type == 'file') {
    //         return asset('public/uploads/chat_images/'.$value, true);
    //     } else {
    //         return $value;
    //     }
    // }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
