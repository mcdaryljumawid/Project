@if (Auth::guard('web')->check())
	<p class="text-success">
		You are logged in as a <strong>USER</strong>
	</p>
@else
	<p class="text-danger">
		You are logged OUT as a <strong>USER</strong>
	</p>
@endif

@if (Auth::guard('customer')->check())
	<p class="text-success">
		You are logged in as a <strong>CUSTOMER</strong>
	</p>
@else
	<p class="text-danger">
		You are logged OUT as a <strong>CUSTOMER</strong>
	</p>
@endif

@if (Auth::guard('worker')->check())
	<p class="text-success">
		You are logged in as a <strong>WORKER</strong>
	</p>
@else
	<p class="text-danger">
		You are logged OUT as a <strong>WORKER</strong>
	</p>
@endif