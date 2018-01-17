@extends('layouts.master')
@include('script')
@section('title')
    Cashier Dashboard | Moley Boley Online Appointment and Operations Management System
@endsection
<br><br><br><br>
<div class="container-fluid" style="padding-left: 100px;">
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
