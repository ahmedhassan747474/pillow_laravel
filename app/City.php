<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class City extends Model
{
    use SoftDeletes;

    public $table = 'cities';

    protected $fillable = [
        'name_ar', 'name_en', 'country_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
