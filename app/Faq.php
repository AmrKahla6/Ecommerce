<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Faq extends Model
{
    use Translatable;
    public $translatedAttributes = ['question','answer'];
}
