<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $table = 'products';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['products'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function categorysub()
    {
        return $this->belongsTo('App\Models\Category','sub_category_id','id');
    }

    public function featureValue()
    {
        return $this->hasMany('App\Models\FeatureValue');
    }
    public function productFeatureItems()
    {
        return $this->hasMany('App\Models\ProductFeatureItems');
    }

    public function productAttribute()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }
    
    public function productTag()
    {
        return $this->hasMany('App\Models\ProductTag');
    }    

    public function productReview()
    {
        return $this->hasMany('App\Models\ProductReview')->select(['id','product_id','user_id','rating']);
    }
	
    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
    } 	

    public function productItem()
    {
        return $this->hasMany('App\Models\ProductItem');
    } 
}
