<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentblog extends Model
{
    use SoftDeletes;
    public function blog()
    {
        return $this->belongsTo('App\Blog');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
