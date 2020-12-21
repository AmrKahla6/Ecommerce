<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['display_name'];
}
