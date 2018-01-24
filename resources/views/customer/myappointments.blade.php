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

<div align="center">
  <button class="add-data-btn btn btn-success">Add Appointment</button>
</div>

<div class="row">
<div class ="col-md-2">
        <div class = "form-group" align="right" style="width: 200px;">
          <select name="choice" id="choice" class="form-control">
              <option value="1">Pending</option>
              <option value="2">History</option>
              <option value="3">Current Appointments</option>
         </select>
   </div>
</div>
</div>

<div id="pending">
<div align="center">
  <h4><strong> My pending appointments </strong></h4>
</div>
<table id="appointments-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Date</td>
      <td>Estimated time start</td>
      <td>Estimated time end</td>
      <td>Worker</td>
      <td>Service</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>
</div>

<div id="history" style="display:none;">
<div align="center">
  <h4><strong> My appointment history </strong></h4>
  </div>
<table id="master-appointments-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Date and Time</td>
      <td>Worker</td>
      <td>Service</td>
      <td>Actions</td>
    </tr>
  </thead>
</table>
</div>

<div id="allappointments" style="display:none;">
<div align="center">
  <h4><strong> Current pending appointments </strong></h4>
</div>
<table id="allappointments-table" class="table" style="font-size: 15px;">
  <thead style="font-weight: bold;">
    <tr>
      <td>Date</td>
      <td>Estimated time start</td>
      <td>Estimated time end</td>
      <td>Worker</td>
      <td>Service</td>
    </tr>
  </thead>
</table>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="viewappointmentdetails"></div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="reschedulemodal"></div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="cancelmodal"></div>


<script type="text/javascript">
	$(function() {
        $('#appointments-table').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax: '/customer/getpendingappointments',
            "order": [[ 1, "asc" ], [ 2, "asc" ]],
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left', orderable: false,},
                {data: 'date', name: 'date', className: 'col-md-1 text-left', orderable: false,},
                {data: 'time', name: 'time', className: 'col-md-1 text-left', orderable: false,},
                {data: 'timeend', name: 'timeend', className: 'col-md-1 text-left', orderable: false,},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left', orderable: false,},
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
            ajax: '/customer/getappointments',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left'},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left'},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false,},
            ], 
          });
      });

  $(function() {
        $('#allappointments-table').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax: '/customer/getcurrentappointments',
            "order": [[ 0, "asc" ], [ 1, "asc" ]],
            columns: [
                {data: 'date', name: 'date', className: 'col-md-1 text-left', orderable: false,},
                {data: 'time', name: 'time', className: 'col-md-1 text-left', orderable: false,},
                {data: 'timeend', name: 'timeend', className: 'col-md-1 text-left', orderable: false,},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left', orderable: false,},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false,},
            ], 
          });
      });

  $(document).off('click','.view-data-btn').on('click','.view-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#viewappointmentdetails").html('');
          $("#viewappointmentdetails").modal();
          $.ajax({
            url: '/customer/viewappointmentdetails/'+that.dataset.id+'',         
            success: function(data) {
              $("#viewappointmentdetails").html(data);
            }
          }); 
        });

   $(document).off('click','.reschedule-data-btn').on('click','.reschedule-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#reschedulemodal").html('');
          $("#reschedulemodal").modal();
          $.ajax({
            url: '/customer/'+that.dataset.id+'/rescheduleform',         
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
            url: '/customer/'+that.dataset.id+'/cancelform',         
            success: function(data) {
              $("#cancelmodal").html(data);
            }
          }); 
        });

  $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#addmodal").html('');
              $("#addmodal").modal();
              $.ajax({
                url: '/customer/addappointment',         
                success: function(data) {
                  $("#addmodal").html(data);
                }
              }); 
        });

$("#choice").change(function(){
    if($(this).val() == 1){
      $("#pending").show();
      $("#history").hide();
      $("#allappointments").hide();
    }else if($(this).val() == 2){
      $("#pending").hide();
      $("#history").show();
      $("#allappointments").hide();
    }else{
      $("#pending").hide();
      $("#history").hide();
      $("#allappointments").show();
    }
});
  </script>
@extends('layouts.footer')