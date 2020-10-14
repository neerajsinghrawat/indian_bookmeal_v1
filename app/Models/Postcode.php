<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
     protected $table = 'postcodes';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['postcodes'];


    public function franchise()
    {
        return $this->belongsTo('App\Models\Franchise');
    }
    
}
