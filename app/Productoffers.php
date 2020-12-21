<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productoffers extends Model
{
    use SoftDeletes;
    protected $fillable = ['from','to','price', 'product_id'];
}
