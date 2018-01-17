<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'servicename', 'serviceprice', 'serviceduration', 'servicetype', 'servicecategory', 'status', 
    ];

    public function appointments()
    {
    	return $this->hasMany('App\Appointment');
    }

    public function transactiondetails()
    {
    	return $this->hasMany('App\TransactionDetail');
    }
}
