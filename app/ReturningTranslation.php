<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturningTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['question','answer'];
}
