<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureGroup extends Model
{
   protected $table = 'feature_groups';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['feature_groups'];

     public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }  

    public function feature()
    {
        return $this->hasMany('App\Models\Feature', 'feature_group_id')->where("features.status", "=", 1);;
    } 

}
