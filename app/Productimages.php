<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productimages extends Model
{
    use SoftDeletes;
    protected $fillable = ['image', 'product_id'];
}
