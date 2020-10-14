<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVisitor extends Model
{
    protected $table = 'website_visitors';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['website_visitors'];
 
     
}
