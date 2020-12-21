<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description','why_choose','why_choose_title_1','why_choose_desc_1','why_choose_title_2','why_choose_desc_2','why_choose_title_3','why_choose_desc_3','why_choose_title_4','why_choose_desc_4'];
}
