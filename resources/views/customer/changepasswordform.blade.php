@extends('layouts.master')
@include('script')
@section('title')
    Change Password | Moley Boley Online Appointment and Operations Management System
@endsection  
<form id="form-change-password" role="form" method="POST" action="{{ url('/customer/changePassword') }}" novalidate class="form-horizontal">
  <div class="col-md-9">             
    <label for="current-password" class="col-sm-4 control-label">Current Password</label>
    <div class="col-sm-8">
      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password">
      </div>
    </div>
    <label for="password" class="col-sm-4 control-label">New Password</label>
    <div class="col-sm-8">
      <div class="form-group">
        <input type="password" class="form-control" id="newpassword" name="new password" placeholder="New Password">
      </div>
    </div>
    <label for="password_confirmation" class="col-sm-4 control-label">Confirm New Password</label>
    <div class="col-sm-8">
      <div class="form-group">
        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="submit" class="btn btn-danger">Submit</button>
    </div>
  </div>
</form>
@extends('layouts.footer')