<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tags';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['product_tags'];
 
     
}
