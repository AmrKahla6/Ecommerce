<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Blog extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = ['image', 'order','status_id'];
    public $translatedAttributes = ['title','description'];
    protected $dates = ['deleted_at'];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function commentblogs()
    {
        return $this->hasMany('App\Commentblog');
    }
}
