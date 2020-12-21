<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorypermission extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * Get the permissions that owns the category.
     */
    public function permissions()
    {
        return $this->hasMany('App\Permission', 'category_id');
    }
}
