<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Worker extends Authenticatable
{
    use Notifiable;

    protected $guard = 'worker';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workerfname', 'workerlname', 'workermname', 'workerdbirth', 'workerbrgy', 'workertown', 'workerprovince', 'workergender', 'workermaritalStatus', 'workerContactNo', 'workerlevel', 'workertype', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
