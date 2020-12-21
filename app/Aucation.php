<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Aucation extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = [ 'end_at','is_publish_comment'];
    public $translatedAttributes = ['title','description'];
    protected $dates = ['deleted_at'];


    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function aucationimages()
    {
        return $this->hasMany('App\Aucationimages');
    }
    public function commentsaucations()
    {
        return $this->hasMany('App\Commentsaucation');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    public function buyer() {
        return $this->belongsTo('App\User','buyer_id');
    
    }
  
}
