@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">REGISTER CUSTOMER </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                           
                        <div class="form-group{{ $errors->has('custfname') ? ' has-error' : '' }}">
                            <label for="custfname" class="col-md-4 control-label">Firstname</label>

                            <div class="col-md-6">
                                <input id="custfname" type="text" class="form-control" name="custfname" value="{{ old('custfname') }}" required autofocus>

                                @if ($errors->has('custfname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custfname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                      
                        <div class="form-group{{ $errors->has('custlname') ? ' has-error' : '' }}">
                            <label for="custlname" class="col-md-4 control-label">Lastname</label>

                            <div class="col-md-6">
                                <input id="custlname" type="text" class="form-control" name="custlname" value="{{ old('custlname') }}" required autofocus>

                                @if ($errors->has('custlname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custlname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                    
                        <div class="form-group{{ $errors->has('custmname') ? ' has-error' : '' }}">
                            <label for="custmname" class="col-md-4 control-label">Middlename</label>

                            <div class="col-md-6">
                                <input id="custmname" type="text" class="form-control" name="custmname" value="{{ old('custmname') }}" required autofocus>

                                @if ($errors->has('custmname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custmname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class ="col-md-4 control-label" for="gender">
                                Gender
                            </label>
                            <div class="col-md-6">
                                <select class="select form-control" id="gender" name="gender" style="width: 200px">
                                    <option value="Male">
                                        Male
                                    </option>

                                    <option value="Female">
                                       Female
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('custContactNo') ? ' has-error' : '' }}">
                            <label for="custContactNo" class="col-md-4 control-label">Contact No.</label>

                            <div class="col-md-6">
                                <input id="custContactNo" type="text" class="form-control" name="custContactNo" value="{{ old('custContactNo') }}" required autofocus>

                                @if ($errors->has('custContactNo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custContactNo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                          <div class="form-group{{ $errors->has('custUsername') ? ' has-error' : '' }}">
                            <label for="custUsername" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="custUsername" type="text" class="form-control" name="custUsername" value="{{ old('custUsername') }}" required autofocus>

                                @if ($errors->has('custUsername'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custUsername') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
    
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                    
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    REGISTER
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
