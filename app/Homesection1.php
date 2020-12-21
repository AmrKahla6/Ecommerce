<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;

class Homesection1 extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $fillable = ['image', 'type','duration_of_new_arrival'];
    public $translatedAttributes = ['title','description','button'];
    protected $dates = ['deleted_at'];
}
