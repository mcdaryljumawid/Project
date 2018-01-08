<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'servicename', 'serviceprice', 'serviceduration', 'servicetype', 'servicecategory', 
    ];

    public function appointments()
    {
    	return $this->hasMany('App\Appointment');
    }
}
