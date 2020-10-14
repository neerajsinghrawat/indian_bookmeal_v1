<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponItem extends Model
{
    protected $table = 'coupon_items';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['coupon_items'];
 	
 
}
