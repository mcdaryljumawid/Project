@extends('layouts.master')
@include('script')
@section('title')
    Customer Dashboard | Moley Boley Online Appointment and Operations Management System
@endsection  
<br><br><br><br>

<div class="container-fluid" style="padding-left: 100px;">
  <h4> My Profile </h4>
    <div class="row">
        <div class="col-sm-2"><strong>Firstname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->custfname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Middlename:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->custmname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Lastname:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->custlname}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Gender</strong></div> 
        <div class="col-sm-10">{{Auth::user()->custgender}}</div>
    </div>

    <div class="row">
        <div class="col-sm-2"><strong>Contact Number:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->custContactNo}}</div>
    </div>      

    <div class="row">
        <div class="col-sm-2"><strong>Email:</strong></div> 
        <div class="col-sm-10">{{Auth::user()->email}}</div>
    </div>    
</div>
@extends('layouts.footer')
