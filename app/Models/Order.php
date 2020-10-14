<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      protected $table = 'orders';
 
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['orders'];
	
	 public function user()
    {
       return $this->belongsTo('App\Models\User');
    }
	
	public function order_items()
    {
			
       return $this->hasMany('App\Models\OrderItem');
    }
	
		

}
