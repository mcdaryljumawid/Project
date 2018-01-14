@extends('layouts.master')
@section('title')
	Manage Transactions | Moley Boley Online Appointment and Operations Management System
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

<div>
  <div align="center">
<button class="add-data-btn btn btn-success">Add Transaction</button><br><br>
<a href="{{ url('/customers') }}"> Click me for new customer. </a>
  <h4><strong> Pending transactions </strong></h4>
  </div>
<table id="transactions-table" class="table">
	<thead>
		<tr>
			<td>Transaction ID</td>
			<td>Date and Time</td>
      <td>Handling user</td>
			<td>Customer</td>
      <td>Status</td>
			<td>Actions</td>
		</tr>
	</thead>
</table>
<br>
<div align="center">
  <h4><strong> Closed transactions </strong></h4>
</div>
<table id="closed-transactions-table" class="table">
  <thead>
    <tr>
      <td>Transaction ID</td>
      <td>Date and Time</td>
      <td>Handling user</td>
      <td>Customer</td>
      <td>Status</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>

<br><br>

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="add-transaction"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="add-transaction-details"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="generatebill"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="transactiondetails"></div>

<script type="text/javascript">
	$(function() {
        $('#transactions-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/transactions/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'handlinguser', name: 'handlinguser', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'status', name: 'status', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
        });

  $(function() {
        $('#closed-transactions-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/transactions/get_datatable_closedtransactions',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'handlinguser', name: 'handlinguser', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'status', name: 'status', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
        });
//call the modal from the triggering button
        $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#add-transaction").html('');
              $("#add-transaction").modal();
              $.ajax({
                url: '/transactions/create',         
                success: function(data) {
                  $("#add-transaction").html(data);
                }
              }); 
        });

        $(document).off('click','.transaction-details-btn').on('click','.transaction-details-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#transactiondetails").html('');
          $("#transactiondetails").modal();
          $.ajax({
            url: '/transactions/'+that.dataset.id+'/transactiondetails',         
            success: function(data) {
              $("#transactiondetails").html(data);
            }
          }); 
        });

        $(document).off('click','.generate-bill-btn').on('click','.generate-bill-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#generatebill").html('');
          $("#generatebill").modal();
          $.ajax({
            url: '/transactions/'+that.dataset.id+'/generatebill',         
            success: function(data) {
              $("#generatebill").html(data);
            }
          }); 
        });

        $(document).off('click','.add-details-btn').on('click','.add-details-btn', function(e){
          e.preventDefault(); 
          var that = this; 
          $("#add-transaction-details").html('');
          $("#add-transaction-details").modal();
          $.ajax({
            url: '/transactions/'+that.dataset.id+'/adddetailsform',      
            success: function(data) {
              $("#add-transaction-details").html(data);
            }
          }); 
        });

        $(document).off('click','.view-transaction-btn').on('click','.view-transaction-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#add-transaction-details").html('');
          $("#add-transaction-details").modal();
          $.ajax({
            url: '/transactions/'+that.dataset.id+'',         
            success: function(data) {
              $("#add-transaction-details").html(data);
            }
          }); 
        });

    });
});
</script>
</div>
@extends('layouts.footer')