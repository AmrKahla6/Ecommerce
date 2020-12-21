<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Package extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}
