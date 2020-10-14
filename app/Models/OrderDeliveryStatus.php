<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryStatus extends Model
{
    protected $table = 'order_delivery_status';
 
 
    public function order()
    {
       return $this->belongsTo('App\Models\Order');
    }

	public function order_items()
    {			
       return $this->hasMany('App\Models\OrderItem','order_id');
    }
		
}

