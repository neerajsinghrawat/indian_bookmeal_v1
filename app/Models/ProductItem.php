<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductItem extends Model
{
    protected $table = 'product_items';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['product_items'];
 
     
}
