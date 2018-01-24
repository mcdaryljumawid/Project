@extends('layouts.master')
@section('title')
	My Transactions | Moley Boley Online Appointment and Operations Management System
@endsection
@include('script')
<br><br><br>
<div class="container" id="needs-validation" novalidate>
  <!-- Trigger the modal with a button -->
<br><br>
<div class="container-fluid mt-4">
    @include('errors')
    @include('success')
</div>

<br>
<div align="center">
  <h4><strong> My Transactions </strong></h4>
</div>
<table id="transactionhistory-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>Transaction ID</td>
      <td>Date and Time</td>
      <td>Handling user</td>
      <td>Customer</td>
      <td>Service Availed</td>
      <td>Bill</td>
    </tr>
  </thead>
</table>

<br><br>

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="transactiondetails"></div>

<script type="text/javascript">
	$(function() {
        $('#transactionhistory-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/worker/gettransactionhistory',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'handlinguser', name: 'handlinguser', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'service', name: 'service', className: 'col-md-1 text-left'},
                {data: 'bill', name: 'bill', className: 'col-md-1 text-left'},
            ],
        });   
    });
</script>
</div>
@extends('layouts.footer')