<?php

namespace App;
use Dimsav\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Archivepoint extends Model
{
    use Translatable;
    protected $fillable = [ 'user_id'];
    public $translatedAttributes = ['description'];
}
