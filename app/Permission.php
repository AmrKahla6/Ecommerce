<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Model;

class Permission extends EntrustPermission
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
     /**
     * Get the category that owns the permission.
     */
    public function category()
    {
        return $this->belongsTo('App\CategoryPermission', 'category_id');
    }
}
