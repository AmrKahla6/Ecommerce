<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productsize extends Model
{
    use SoftDeletes;
    protected $fillable = ['size', 'product_id'];
}
