<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGetway extends Model
{
   protected $table = 'payment_getways';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['payment_getways'];


}
