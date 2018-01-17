@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" align="center">Customer Login</div>
                @if(Session::get('message') !== null)
                <div class="alert alert-block alert-danger" align="center">
                {{ Session::get('message') !== null ? Session::get('message') : '' }}
                </div>
              
                @endif

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('customer.login.submit') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('custUsername') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="custUsername" type="custUsername" class="form-control" name="custUsername" value="{{ old('custUsername') }}" required autofocus>

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
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
