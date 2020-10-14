<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningTime extends Model
{
    protected $table = 'opening_times';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['opening_times'];
 
     
}
