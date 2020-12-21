<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Role extends EntrustRole
{

    use Translatable;
    use SoftDeletes;
    protected $fillable = ['name', 'description'];
    public $translatedAttributes = ['display_name'];
    protected $dates = ['deleted_at'];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
