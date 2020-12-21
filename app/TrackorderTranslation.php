<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackorderTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['question','answer'];
}
