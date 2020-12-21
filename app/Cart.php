<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cart extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function position()
    {
        return $this->belongsTo('App\Position');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
