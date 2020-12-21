<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Subcategory extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = [ 'order','category_id'];
    public $translatedAttributes = ['name','description'];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function subsubcategories()
    {
        return $this->hasMany('App\Subsubcategory');
    }
}
