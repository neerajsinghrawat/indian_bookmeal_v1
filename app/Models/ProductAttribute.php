<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
     protected $table = 'product_attributes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['product_attributes'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }    
}
