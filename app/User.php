<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $fillable = ['image', 'name_of_company','name_of_owner', 'email'
    ,'phone', 'url','commercial_number' ,'desc', 'address','password'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles() {
      return $this->belongsToMany('App\Role');
    }
    public function status() {
      return $this->belongsTo('App\Status');
    }
    public function requestpoints() {
      return $this->hasMany('App\Requestpoint');
    }
    public function currency() {
      return $this->belongsTo('App\Currency');
    }
    public function city() {
      return $this->belongsTo('App\City');
    }
    public function companyimages() {
      return $this->hasMany('App\Companyimag');
    }
    public function carts() {
      return $this->hasMany('App\Cart');
    }
    public function orders() {
      return $this->hasMany('App\Order');
    }
    public function archivepoints() {
      return $this->hasMany('App\Archivepoint');
    }

    public function bought_aucations() {
      return $this->hasMany('App\Aucation','buyer_id');
    }
    public function aucations() {
      return $this->hasMany('App\Aucation');
    }
    public function aggregations() {
      return $this->hasMany('App\Aggregation');
    }
    public function aggregationgroups() {
      return $this->hasMany('App\Aggregationgroup');
    }
    public function products(){
      return $this->hasMany('App\Product');
    }
    public function reviews(){
      return $this->hasMany('App\Review');
    }
     use EntrustUserTrait;


}
