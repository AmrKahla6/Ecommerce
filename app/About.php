<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class About extends Model
{
    use Translatable;

    public $translatedAttributes = ['title','description','why_choose','why_choose_title_1','why_choose_desc_1','why_choose_title_2','why_choose_desc_2','why_choose_title_3','why_choose_desc_3','why_choose_title_4','why_choose_desc_4'];
}
