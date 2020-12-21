<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productcolors extends Model
{
    use SoftDeletes;
    protected $fillable = ['color','image', 'product_id'];
}
