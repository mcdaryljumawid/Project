<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
	protected $fillable = [
        'appointDateTime', 'datetimeResched', 'appointStatus', 'appointRemarks', 'service_id', 'worker_id', 'customer_id', 
    ];

	public function service()
	{
    	return $this->belongsTo('App\Service');
	}

	public function worker()
	{
		return $this->belongsTo('App\Worker');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}
}

