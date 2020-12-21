<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Contactinfo extends Model
{
    use Translatable;
    public $translatedAttributes = ['location'];
}
