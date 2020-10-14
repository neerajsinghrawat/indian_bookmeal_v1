<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureValue extends Model
{
   protected $table = 'feature_values';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['feature_values'];
}
