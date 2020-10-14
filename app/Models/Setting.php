<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
 
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['settings'];

    public function openingTime()
    {
        return $this->hasMany('App\Models\OpeningTime');
    }

}
