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
                        <li class="{{ Request::is('customer') ? 'active': '' }}"><a href="{{ url('/customer') }}">Dashboard</a>
                        <li class="{{ Request::is('customer/myappointments') ? 'active': '' }}""><a href="{{ url('/customer/myappointments') }}">My Appointments</a>
                        <li class="{{ Request::is('customer/mytransactions') ? 'active': '' }}"><a href="{{ url('/customer/mytransactions') }}">My Transactions</a>
                    @elseif (Auth::guard('worker')->check())
                        <li class="{{ Request::is('worker') ? 'active': '' }}"><a href="{{ url('/worker') }}">Dashboard</a>
                        <li class="{{ Request::is('worker/myappointments') ? 'active': '' }}"><a href="{{ url('/worker/myappointments') }}">My Appointments</a>
                        <li class="{{ Request::is('worker/transactions') ? 'active': '' }}""><a href="{{ url('/worker/mytransactions') }}">My Transactions</a>
                            <li class="{{ Request::is('worker/mygrossincome') ? 'active': '' }}"><a href="{{ url('/worker/mygrossincome') }}">Gross Income</a>
                    @elseif (Auth::user()->role == "Manager")
                        <li class="{{ Request::is('users') ? 'active': '' }}"><a href="{{ url('/users') }}">Users</a>
                        <li class="{{ Request::is('workers') ? 'active': '' }}"><a href="{{ url('/workers') }}">Workers</a>
                        <li class="{{ Request::is('customers') ? 'active': '' }}"><a href="{{ url('/customers') }}">Customers</a>
                        <li class="{{ Request::is('services') ? 'active': '' }}"><a href="{{ url('/services') }}">Services</a>
                        <li class="{{ Request::is('appointments') ? 'active': '' }}"><a href="{{ url('/appointments') }}">Appointment</a>
                        <li class="{{ Request::is('transactions') ? 'active': '' }}"><a href="{{ url('/transactions') }}">Transaction and Bill</a>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Gross Income
                            <span class="caret"></span>
                            </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('/grossincome') }}">Gross Income</a>
                            </li>
                            <li>
                                <a href="{{ url('grossincome/byworker') }}">Worker Breakdown</a>
                            </li>
                        </ul>
                        </li>
                        
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Report
                            <span class="caret"></span>
                            </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('/reports') }}">Projected income & Shop performance</a>
                                <a href="{{ url('/reports/workerperformance') }}">Worker performance</a>
                            </li>
                        </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/customers') }}">Customers</a>
                        <li><a href="{{ url('/appointments') }}">Appointment</a>
                        <li><a href="{{ url('/transactions') }}">Transaction and Bill</a>
                        <li><a href="generatereport.php">Generate Reports</a>
                    @endif 
                </ul>

                <ul class="nav navbar-nav navbar-right">
                 <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                   <strong> Welcome </strong> &nbsp; 
                                    @if (Auth::guard('customer')->check())
                                        {{ Auth::user()->custlname }}, {{ Auth::user()->custfname }}
                                    @endif

                                    @if (Auth::guard('worker')->check())
                                        {{ Auth::user()->workerlname }}, {{ Auth::user()->workerfname }}
                                    @endif

                                    @if(Auth::guard('customer')->check() != true && Auth::guard('worker')->check() != true)
                                        {{ Auth::user()->lastname }}, {{ Auth::user()->firstname }}
                                    @endif 
                                     <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        @if (Auth::guard('worker')->check())
                                        <a href="{{ url('/worker/changePassword') }}">
                                            Change Password
                                        </a>
                                        @elseif (Auth::guard('customer')->check())
                                        <a href="{{ url('/customer/changePassword') }}">
                                            Change Password
                                        </a>
                                        @else
                                        <a href="{{ url('/changePassword') }}">
                                            Change Password
                                        </a>
                                        @endif
                                    </li>
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