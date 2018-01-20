@extends('layouts.master')
@include('script')
@section('title')
    Cashier Dashboard | Moley Boley Online Appointment and Operations Management System
@endsection
<br><br><br><br>

<div class="container" >
    <div class="row">
    <div class="col-md-4">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="fa fa-user-o" aria-hidden="true"></i></div>
            <div class="num">{{ $customercount }}</div>
            <h3>Customers</h3>
            <p>Total Customers</p>
        </div>    
    </div>
    <div class="col-md-4">
        <div class="tile-stats tile-blue">
            <div class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
            <div class="num">{{ $appointmentcount }}</div>         
            <h3>Appointments</h3>
            <p>Total Pending Appointments</p>
        </div>        
    </div>
    <div class="col-md-4">
        <div class="tile-stats tile-orange">
            <div class="icon"><i class="fa fa-money"></i></div>
            <div class="num">{{ $transactioncount }}</div>        
            <h3>Transactions</h3>
            <p>Total Pending Transactions</p>
        </div>        
    </div>
</div>

<h4> My Profile </h4>
    <div class="row">
        <div class="col-sm-2"><strong>Firstname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->firstname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Middlename:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->middlename}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Lastname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->lastname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Role:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->role}}</div>
    </div>   
</div>
@extends('layouts.footer')
