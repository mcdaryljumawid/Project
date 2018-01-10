<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'workergrossincome', 'companygrossincome', 'service_id', 'worker_id', 'transaction_id', 
    ];

	public function service()
	{
    	return $this->belongsTo('App\Service');
	}

	public function worker()
	{
		return $this->belongsTo('App\Worker');
	}

	public function transaction()
	{
		return $this->belongsTo('App\Transaction');
	}
}
