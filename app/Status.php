<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Status extends Model
{
    use Translatable;
    use SoftDeletes;
    public $translatedAttributes = ['name'];
    protected $dates = ['deleted_at'];

    public function companies()
    {
        return $this->hasMany('App\Company');
    }
}
