<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenHour extends Model
{
    protected $table = 'open_hours';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['open_hours'];
 
     
}
