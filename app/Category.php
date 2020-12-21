<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Category extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = [ 'order'];
    public $translatedAttributes = ['name','description'];
    protected $dates = ['deleted_at'];

    public function subcategories()
    {
        return $this->hasMany('App\Subcategory');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
