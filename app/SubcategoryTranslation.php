<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubcategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name','description'];
}
