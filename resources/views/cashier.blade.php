@extends('layouts.master')
@include('script')
@section('title')
    Cashier Dashboard | Moley Boley Online Appointment and Operations Management System
@endsection
<br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> Cashier Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!--You are logged in as CASHIER!-->
                    @component('components.who')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@extends('layouts.footer')
