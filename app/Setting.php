<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable , SoftDeletes;

    protected $fillable = ['image','order'];
    public $translatedAttributes = ['title','description'];
    protected $dates = ['deleted_at'];
}
