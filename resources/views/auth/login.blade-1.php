<!DOCTYPE html>
<html lang="en">
<link href="css/style.css" rel="stylesheet" type="text/css">
<head>
	<meta charset="utf-8">
	<title>Manager Login</title>
	<link rel="stylesheet" href="css/style.css">
	<meta name="description" content="IT Project">
</head>
<body>
	<div class="loginBox">
		<img src="images/flogo.png" class="user">

		<h1>Manager</h1>
	
	<form class="form-horizontal" method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}

		<div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
			<p>User ID</p>
			<input id="id" type="id" class="form-control" name="id" value="{{ old('id') }}" required autofocus>
			 @if ($errors->has('id'))
             <span class="help-block">
                <strong>{{ $errors->first('id') }}</strong>
             </span>
            @endif
    	</div>	

    	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
             <p>Password</p>
             <input id="password" type="password" class="form-control" name="password" required>
             @if ($errors->has('password'))
             <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
             </span>
             @endif
        </div>

        <button type="submit" class="btn btn-primary">
            Login
        </button>
	</form>
	</div>
</body>
</html>