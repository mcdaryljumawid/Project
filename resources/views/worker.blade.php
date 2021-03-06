@extends('layouts.master')
@include('script')
@section('title')
    Worker Dashboard | Moley Boley Online Appointment and Operations Management System
@endsection
<br><br><br><br>

<div class="container">

    <div class="col-md-4">
        <div class="tile-stats tile-orange">
            <div class="icon"><i class="fa fa-money"></i></div>
            <div class="num">{{ $transactioncount }}</div>       
            <h3>Transactions</h3>
            <p>Total Number of Transactions</p>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="tile-stats tile-green">
            <div class="icon"><i class="fa fa-calendar-o" aria-hidden="true"></i></div>
            <div class="num">{{ $pendingcount }}</div>
            <h3>Pending Appointments</h3>
            <p>Total Pending Appointments</p>
        </div>    
    </div>

    <div class="col-md-4">
        <div class="tile-stats tile-blue">
            <div class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
            <div class="num">{{ $appointmentcount }}</div>         
            <h3>Appointments</h3>
            <p>Total Appointments</p>
        </div>        
    </div>

  <h4> My Profile </h4>
    <div class="row">
        <div class="col-sm-2"><strong>Firstname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerfname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Middlename:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workermname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Lastname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerlname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Date of Birth:</strong></div> 
        <div class="col-sm-10">{{ date('M d, Y', strtotime(Auth::user()->workerdbirth)) }}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Barangay:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerbrgy}}</div>
    </div>      

    <div class="row">
        <div class="col-sm-2"><strong>Town:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workertown}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Province:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerprovince}}</div>
    </div>   

    <div class="row">
        <div class="col-sm-2"><strong>Gender:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workergender}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Marital Status:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workermaritalStatus}}</div>
    </div> 

    <div class="row">
        <div class="col-sm-2"><strong>Contact Number:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerContactNo}}</div>
    </div>  

    <div class="row">
        <div class="col-sm-2"><strong>Level:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workerlevel}}</div>
    </div>  

    <div class="row">
        <div class="col-sm-2"><strong>Type:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->workertype}}</div>
    </div>  
</div>
@extends('layouts.footer')
