<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('manager');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = \App\Worker::all();
        $workercount = $workers->count();

        $customers = \App\Customer::all();
        $customercount = $customers->count();

        $appointments = \App\Appointment::where('appointStatus', "Pending");
        $appointmentcount = $appointments->count();

        $transactions = \App\Transaction::where('transactStatus', "Pending");
        $transactioncount = $transactions->count();


        return view('home', compact(['workercount', 'customercount', 'appointmentcount', 'transactioncount']));
    }
}
