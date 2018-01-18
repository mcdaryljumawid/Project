<!-- Navbar -->
	<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">
					<img src="images/logo2.png" />
				</a>
			</div>
			<div class="collapse navbar-collapse navbar-right" id="navbar-collapse" >
				<ul class="nav navbar-nav">
					<li class="{{ Request::is('/') ? 'active': '' }}"><a href="{{ url('/') }}">Home</a>
					<li class="{{ Request::is('services') ? 'active': '' }}"><a href="services.php">Services</a>
					<li><a href="about_us.php">About Us</a>
					<li><a href="contact_us.php">Contact Us</a>
					<li><a href="{{ url('/registercustomer') }}">Register</a>
					<li class="{{ Request::is('logindirect') ? 'active': '' }}"><a href="{{ url('/logindirect') }}">Log in</a>
				</ul>
			</div>
		</div>
	</nav>
