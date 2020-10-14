<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAttribute extends Model
{
    protected $table = 'order_attributes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['order_attributes'];
 
     
}
