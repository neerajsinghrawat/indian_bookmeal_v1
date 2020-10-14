<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingTax extends Model
{
    protected $table = 'shipping_taxes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['shipping_taxes'];

}
