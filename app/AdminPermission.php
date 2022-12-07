<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPermission extends Model
{
    protected $table = 'admin_permission';
    
    protected $fillable = ['admin_id', 'permission_id', 'can_create', 'can_edit', 'can_show', 'can_delete'];
    
    protected $hidden = ['created_at','updated_at'];
    
    protected $dates = ['created_at','updated_at'];

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function permission()
    {
        return $this->belongsTo('App\Permission', 'permission_id');
    }
}