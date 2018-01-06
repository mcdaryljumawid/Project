<!-- Narbar -->

<div id="app">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="../images/logo2.png" />
               </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    @if (Auth::guard('customer')->check())
                        <li><a href="appointment.php">Dashboard</a>
                        <li><a href="appointment.php">My Appointments</a>
                        <li><a href="transaction_and_bill.php">My Transactions</a>
                        <li><a href="gross_income.php"></a>
                        <li><a href="generatereport.php">Generate Reports</a>
                    @elseif (Auth::guard('worker')->check())
                        <li><a href="appointment.php">My Appointments</a>
                        <li><a href="transaction_and_bill.php">My Transactions</a>
                        <li><a href="gross_income.php"></a>
                        <li><a href="generatereport.php">Generate Reports</a>
                    @elseif (Auth::user()->role == "Manager")
                        <li><a href="{{ url('/users') }}">Users</a>
                        <li><a href="{{ url('/workers') }}">Workers</a>
                        <li><a href="{{ url('/customers') }}">Customers</a>
                        <li><a href="{{ url('/services') }}">Services</a>
                        <li><a href="{{ url('/appointments') }}">Appointment</a>
                        <li><a href="transaction_and_bill.php">Transaction and Bill</a>
                        <li><a href="gross_income.php">Gross Income</a>
                        <li><a href="generatereport.php">Generate Reports</a>
                    @else
                        <li><a href="{{ url('/customers') }}">Customers</a>
                        <li><a href="appointment.php">Appointment</a>
                        <li><a href="transaction_and_bill.php">Transaction and Bill</a>
                        <li><a href="generatereport.php">Generate Reports</a>
                    @endif 
                </ul>

                <ul class="nav navbar-nav navbar-right">
                 <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                   <strong> Welcome </strong> &nbsp; 
                                    @if (Auth::guard('customer')->check())
                                        {{ Auth::user()->custlname }}, {{ Auth::user()->custfname }}
                                    @elseif (Auth::guard('worker')->check())
                                        {{ Auth::user()->workerlname }}, {{ Auth::user()->workerfname }}
                                    @else
                                        {{ Auth::user()->lastname }}, {{ Auth::user()->firstname }}
                                    @endif 
                                     <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        @if (Auth::guard('customer')->check())
                                        <a href="{{ route('customer.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

                                        @elseif (Auth::guard('worker')->check())
                                        <a href="{{ route('worker.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('worker.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        @else
                                        <a href="{{ route('user.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        @endif
                                    </li>
                                </ul>
                            </li>
                        </ul>
            </div>
        </div>
    </nav>
</div>