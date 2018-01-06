<!DOCTYPE html>
<html lang="en">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<head>
	<meta charset="utf-8">
	<title>
		Login Direct | Moley Boley Online Appointment and Operations Management System
	</title>
	<meta name="description" content="IT Project">
	@extends('layouts.resources')
</head>
<body>
	@extends('layouts.guestnavigationbar')
<body background="images/cover2.jpg">
<br><br>
<img src="images/flogo.png" width="500" height="300" class="center-block">
<br>
<img src="images/flogo1.png" width="400" height="100" class="center-block">
<br><br><br>

<div class="container_table">
	<div class="row">
		<div class="col-md-1 col-md-offset-2 text-center">
			
			<h2>MANAGER</h2>

			<p>
				Manage appointments and transactions. View reports and performance.
			</p>
			<button id="btnSubmit" class="btn btndefault"><a href="{{ url('/login') }}">Click to Login</a></button>
		</div>

		<div class="col-md-1 col-md-offset-1 text-center">
			
			<h2>CASHIER</h2>

			<p>
				Manage day-to-day operations. 
			</p>
			<button id="btnSubmit" class="btn btndefault"><a href="{{ url('/login') }}">Click to Login</a></button>
			
		</div>

		<div class="col-md-1 col-md-offset-1 text-center">
			
			<h2>CUSTOMER</h2>

			<p>
				Book appointment, manage your appointments, view your past transactions.
			</p>
			<button id="btnSubmit" class="btn btndefault"><a href="{{ url('/customer/login') }}">Click to Login</a></button>
			
		</div>

		<div class="col-md-1 col-md-offset-1 text-center">
			<h2>WORKER</h2>

			<p>
				Monitor your appointments, and working performance. View your gross income and your transaction history.
			</p>
			<button id="btnSubmit" class="btn btndefault"><a href="{{ url('/worker/login') }}">Click to Login</a></button>
		</div>

	</div>
</div>
@extends('layouts.footer')