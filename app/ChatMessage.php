<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class ChatMessage extends Model
{
    protected $table = 'chat_message';

    protected $fillable = [
        'message', 'type', 'is_read', 'chat_id', 'user_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['updated_at'];

    protected $dates = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function chat()
    {
        return $this->belongsTo('App\Chat', 'chat_id');
    }

    public function getMessageAttribute($value)
    {
        if($this->type == 'file') {
            return asset('public/uploads/chat_images/'.$value, true);
        } else {
            return $value;
        }
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
