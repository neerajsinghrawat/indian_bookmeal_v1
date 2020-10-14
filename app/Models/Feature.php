<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
   protected $table = 'features';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['features'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
     public function featureValue()
    {
        return $this->hasMany('App\Models\FeatureValue');
    }
}
