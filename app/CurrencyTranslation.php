<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
