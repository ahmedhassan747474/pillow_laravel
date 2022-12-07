<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $table = 'otp_code';

    protected $fillable = [
    	'user_id', 'code_type', 'verification_code', 'status'
    ];

    protected $hidden = ['created_at','updated_at'];

    protected $dates = ['created_at','updated_at'];
}
