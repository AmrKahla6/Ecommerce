<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AucationTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description'];
}
