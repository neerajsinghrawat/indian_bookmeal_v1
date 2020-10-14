<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFeatureAttribute extends Model
{
   protected $table = 'product_feature_attributes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['product_feature_attributes'];


	 public function productFeature()
    {
       return $this->belongsTo('App\Models\ProductFeature');
    }    
}
