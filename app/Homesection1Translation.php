<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homesection1Translation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description','button'];
}
