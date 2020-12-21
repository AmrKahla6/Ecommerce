<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Currency extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = ['image', 'short_code','contain_in_dollar'];
    public $translatedAttributes = ['name'];
    protected $dates = ['deleted_at'];

    public function subcategories()
    {
        return $this->hasMany('App\Subcategory');
    }
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
