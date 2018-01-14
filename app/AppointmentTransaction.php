<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentTransaction extends Model
{
     protected $fillable = [
         'transaction_id', 'appointment_id',
    ];

     protected $table = 'appointment_transactions';
    
    public function transaction()
	{
    	return $this->belongsTo('App\Transaction');
	}

	public function appointment()
	{
    	return $this->belongsTo('App\Appointment');
	}


}
