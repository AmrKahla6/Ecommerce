<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Product extends Model
{
    use SoftDeletes;
    use Translatable;
    protected $fillable = ['image', 'order','category_id','sale','status_id', 'currency_id','company_id','subcategory_id'];
    public $translatedAttributes = ['name','description'];

    public function productimages()
    {
        return $this->hasMany('App\Productimages');
    }
    public function productcolors()
    {
        return $this->hasMany('App\Productcolors');
    }
    public function productoffers()
    {
        return $this->hasMany('App\Productoffers');
    }
    public function productsizes()
    {
        return $this->hasMany('App\Productsize');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }
    public function position()
    {
        return $this->belongsTo('App\Position');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
 
    public function orders() {
        return $this->hasMany('App\Order');
    }
    public function reviews() {
        return $this->hasMany('App\Review');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
