<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commentsaucation extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
