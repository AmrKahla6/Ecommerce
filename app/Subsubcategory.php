<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Subsubcategory extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = ['image', 'order','category_id','subcategory_id'];
    public $translatedAttributes = ['name','description'];
    protected $dates = ['deleted_at'];

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function aucations()
    {
        return $this->hasMany('App\Aucation');
    }
    public function aggregations()
    {
        return $this->hasMany('App\Aggregation');
    }
}
