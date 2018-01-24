@extends('layouts.master')
@section('title')
	Manage Appointments | Moley Boley Online Appointment and Operations Management System
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

<div align="center">
<button class="add-data-btn btn btn-success">Add Appointment</button><br><br>
</div>


<div class="row">
<div class ="col-md-2">
        <div class = "form-group" align="right">
          <select name="choice" id="choice" class="form-control" style="width:300px;">
              <option value="1">Pending</option>
              <option value="2">History</option>
              <option value="3">Transactions from Appointment</option>
         </select>
   </div>
</div>
</div>

<div id = "pending">
  <div align="center">
  <h4><strong> Pending appointments </strong></h4>
  </div>
<table id="appointments-table" class="table" style="font-size: 15px;">
	<thead style="font-weight: bold;">
		<tr>
			<td>ID</td>
			<td>Date</td>
      <td>Estimated time start</td>
      <td>Estimated time end</td>
			<td>Customer</td>
			<td>Worker</td>
			<td>Service</td>
			<td>Actions</td>
		</tr>
	</thead>
</table>
</div>

<div id="history" style="display:none;">
<div align="center">
  <h4><strong> Appointment history </strong></h4>
  </div>
<table id="appointment-history-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Date and Time</td>
      <td>Customer</td>
      <td>Worker</td>
      <td>Service</td>
      <td>Status</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>
</div>

<div id="appointmenttransactions" style="display:none;">
<div align="center">
  <h4><strong> Transactions from Appointment </strong></h4>
  </div>
<table id="appointment-transaction-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>Appointment no.</td>
      <td>Transaction no.</td>
      <td>Customer</td>
      <td>Worker</td>
      <td>Service</td>
      <td>Price</td> 
    </tr> 
  </thead>
</table>
</div>

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="viewmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="reschedulemodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="cancelmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="transactionmodal"></div>

<script type="text/javascript">
	$(function() {
        $('#appointments-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
              "order": [[ 1, "asc" ], [ 2, "asc" ]],
            ajax: '/appointments/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left', orderable: false,},
                {data: 'date', name: 'date', className: 'col-md-1 text-left', orderable: false,},
                {data: 'time', name: 'time', className: 'col-md-1 text-left', orderable: false,},
                {data: 'timeend', name: 'timeend', className: 'col-md-1 text-left', orderable: false,},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left', orderable: false,},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left', orderable: false,},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
        });

  $(function() {
        $('#appointment-history-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/appointments/get_datatable_appointhistory',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left'},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
                {data: 'status', name: 'status', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
        });

    $(function() {
        $('#appointment-transaction-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/appointments/get_datatable_appointtransaction',
            columns: [
                {data: 'appointmentid', name: 'appointmentid', className: 'col-md-1 text-left'},
                {data: 'transactionid', name: 'transactionid', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left'},
                {data: 'service', name: 'service', className: 'col-md-1 text-left'},
                {data: 'amount', name: 'amount', className: 'col-md-1 text-left', orderable: false,}, 
            ],
        });
//call the modal from the triggering button
        $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#addmodal").html('');
              $("#addmodal").modal();
              $.ajax({
                url: '/appointments/create',         
                success: function(data) {
                  $("#addmodal").html(data);
                }
              }); 
        });

        $(document).off('click','.view-data-btn').on('click','.view-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#viewmodal").html('');
          $("#viewmodal").modal();
          $.ajax({
            url: '/appointments/'+that.dataset.id+'',         
            success: function(data) {
              $("#viewmodal").html(data);
            }
          }); 
        });

        $(document).off('click','.reschedule-data-btn').on('click','.reschedule-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#reschedulemodal").html('');
          $("#reschedulemodal").modal();
          $.ajax({
            url: '/appointments/'+that.dataset.id+'/rescheduleform',         
            success: function(data) {
              $("#reschedulemodal").html(data);
            }
          }); 
        });

        $(document).off('click','.cancel-data-btn').on('click','.cancel-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#cancelmodal").html('');
          $("#cancelmodal").modal();
          $.ajax({
            url: '/appointments/'+that.dataset.id+'/cancelform',         
            success: function(data) {
              $("#cancelmodal").html(data);
            }
          }); 
        });

        $(document).off('click','.make-transaction-btn').on('click','.make-transaction-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#transactionmodal").html('');
          $("#transactionmodal").modal();
          $.ajax({
            url: '/appointments/'+that.dataset.id+'/appointmenttransactionform',         
            success: function(data) {
              $("#transactionmodal").html(data);
            }
          }); 
        });

    });
  });
});

$("#choice").change(function(){
    if($(this).val() == 1){
      $("#pending").show();
      $("#history").hide();
      $("#appointmenttransactions").hide();
    }else if($(this).val() == 2){
      $("#pending").hide();
      $("#history").show();
      $("#appointmenttransactions").hide();
    }else{
      $("#pending").hide();
      $("#history").hide();
      $("#appointmenttransactions").show();
    }
});
</script>
</div>
@extends('layouts.footer')