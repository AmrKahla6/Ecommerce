<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Shipping extends Model
{
    use Translatable;
    public $translatedAttributes = ['question','answer'];
}
