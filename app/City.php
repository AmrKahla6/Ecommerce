<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class City extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = [];
    public $translatedAttributes = ['name'];
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
