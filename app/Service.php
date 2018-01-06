<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'servicename', 'serviceprice', 'serviceduration', 'servicetype', 
    ];

    public function appointments()
    {
    	return $this->hasMany('App\Appointment');
    }
}
