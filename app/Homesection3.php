<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Homesection3 extends Model
{
    use Translatable;
    protected $fillable = ['type'];
    public $translatedAttributes = ['title'];
}
