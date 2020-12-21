<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Homesection2 extends Model
{
    use Translatable;
    protected $fillable = ['image'];
    public $translatedAttributes = ['title','description'];
}
