<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cashier');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = \App\Customer::all();
        $customercount = $customers->count();

        $appointments = \App\Appointment::where('appointStatus', "Pending");
        $appointmentcount = $appointments->count();

        $transactions = \App\Transaction::where('transactStatus', "Pending");
        $transactioncount = $transactions->count();

        return view('cashier', compact(['customercount', 'appointmentcount', 'transactioncount']));
    }
}
