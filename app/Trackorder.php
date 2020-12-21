<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Trackorder extends Model
{
    use Translatable;
    public $translatedAttributes = ['question','answer'];
    
}
