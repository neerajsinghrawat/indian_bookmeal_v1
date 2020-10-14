<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couponcode extends Model
{
    protected $table = 'couponcodes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['couponcodes'];
 	
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    } 	

    public function couponItem()
    {
        return $this->hasMany('App\Models\CouponItem','couponcode_id','id');
    }
}
