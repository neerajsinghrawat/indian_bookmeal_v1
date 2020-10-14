<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
      protected $table = 'product_reviews';
 
 
    public function user(){
		 return $this->belongsTo('App\Models\User');
	}

}
