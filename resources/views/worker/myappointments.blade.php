@extends('layouts.master')
@section('title')
	My Appointments | Moley Boley Online Appointment and Operations Management System
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

<div class="row">
<div class ="col-md-2">
        <div class = "form-group" align="right">
          <select name="choice" id="choice" class="form-control">
              <option value="1">Pending</option>
              <option value="2">History</option>
         </select>
   </div>
</div>
</div>

<div id="pending">
<div align="center">
  <h4><strong> Pending appointments </strong></h4>
  </div>
<table id="appointments-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Date and Time</td>
      <td>Customer</td>
      <td>Service</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>
</div>

<div id="history" style="display:none;">
<div align="center">
  <h4><strong> Closed and Cancelled appointments </strong></h4>
  </div>
<table id="master-appointments-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Date and Time</td>
      <td>Customer</td>
      <td>Service</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="viewappointmentdetails"></div>>


<script type="text/javascript">
	$(function() {
        $('#appointments-table').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax: '/worker/getpendingappointments',
            "order": [ 1, "asc" ],
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left', orderable: false,},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left', orderable: false,},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left', orderable: false,},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false,},
            ], 
          });
      });

  $(function() {
        $('#master-appointments-table').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax: '/worker/getappointments',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'customername', name: 'customername', className: 'col-md-1 text-left'},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false,},
            ], 
          });
      });

  $(document).off('click','.view-data-btn').on('click','.view-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#viewappointmentdetails").html('');
          $("#viewappointmentdetails").modal();
          $.ajax({
            url: '/worker/viewappointmentdetails/'+that.dataset.id+'',         
            success: function(data) {
              $("#viewappointmentdetails").html(data);
            }
          }); 
        });

  $("#choice").change(function(){
    if($(this).val() == 1){
      $("#pending").show();
      $("#history").hide();
    }else{
      $("#pending").hide();
      $("#history").show();
    }
});
  </script>
@extends('layouts.footer')