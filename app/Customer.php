<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'custfname', 'custlname', 'custmname', 'custgender', 'custContactNo', 'email', 'custUsername', 'password', 'status', 
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

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
