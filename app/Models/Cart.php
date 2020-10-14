<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
      protected $table = 'carts';
 
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['carts'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
