<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transactBill', 'transactStatus', 'user_id', 'customer_id', 
    ];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function transactiondetails()
    {
        return $this->hasMany('App\TransactionDetail');
    }
}
