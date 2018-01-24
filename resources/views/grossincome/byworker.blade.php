@extends('layouts.master')
<!--@include('script')-->
@section('title')
	Worker Breakdown | Moley Boley Online Appointment and Operations Management System
@endsection
@include('script')
<br><br><br>
<div class="container">
 <form class="form-horizontal" method="GET" action="/grossincome/getbyworker" id="byworker-form">
  
  <div class="row">
      <div class = "col-md-2">
        <div class = "form-group">
          <select name="choice" id="choice" class="form-control">
              <option value="0" selected disabled>Date</option>
              <option value="1">Yearly</option>
              <option value="2">Monthly</option>
              <option value="3">Daily</option>
              <option value="4">Date in Between</option>
          </select>
        </div>
      </div>
  </div>


  <div class="form-group">
        <label class ="control-label col-sm-4">Worker</label>
                <div class="col-sm-7">
                      <select class="select form-control " id="worker_id" name="worker_id" style="width: 200px">
                            @foreach($workers as $worker)
                              <option value="{{ $worker->id }}">{{ $worker->workerlname }}, {{ $worker->workerfname }}</option>
                            @endforeach
                      </select>
        <span class="help-text text-danger"></span>
                </div>
  </div>

  <div class="row">
      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <select name="year" id="year" class="form-control" style="display:none;">
            <option selected disabled>Choose a year</option>
            @for ($i=2018; $i >= 2000; $i--)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>

      <div class = "col-md-2">
        <div class = "form-group">
          <select name="month" id="month" class="form-control" style="display:none;">
              <option selected disabled>Choose a month</option>
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
          </select>
        </div>
      </div>

  <div class="row">
      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <input  id="date1" type="date" name="date1" class="form-control" style="display:none;">
        </div>
  </div>

      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <input type="date" name="date2" id="date2" class="form-control" style="display:none;">
        </div>
      </div>
  </div>
 </form>

<div class="row">
<div class = "col-md-2">
  <button class="submit-data-btn btn btn-success">View Worker Breakdown</button>
</div>
</div>

<div>
<table id="byworker-table" class="table" style="font-size: 15px; display:none;">
  <thead style="font-weight: bold;">
    <tr>
        <td>Transaction No.</td>
        <td>Worker No.</td>
        <td>Worker Name</td>
        <td>Date and Time</td>
        <td>Service Rendered</td>
        <td>Gross income</td>
    </tr>
</thead>
</table>
</div>
</div>

<script type="text/javascript">

	$("#choice").change(function(){
    var token = $("input[name='_token']").val();
    if($(this).val() == 1){
      $("#year").show();
      $("#month").hide();
      $("#date1").hide();
      $("#date2").hide();
    }else if($(this).val() == 2){
      $("#year").show();
      $("#month").show();
      $("#date1").hide();
      $("#date2").hide();
    }else if($(this).val() == 3){
      $("#year").hide();
      $("#month").hide();
      $("#date1").show();
      $("#date2").hide();
    }else if($(this).val() == 4){
      $("#year").hide();
      $("#month").hide();
      $("#date1").show();
      $("#date2").show();
    }
});

  $(function(){
    $(document).off('click','.submit-data-btn').on('click','.submit-data-btn', function(e){
        e.preventDefault();
          var $form = $('#byworker-form');
          var $url = $form.attr('action');
          var choice = document.getElementById("choice").value;
          var worker_id = document.getElementById("worker_id").value;
          var year = document.getElementById("year").value;
          var month = document.getElementById("month").value;
          var date1 = document.getElementById("date1").value;
          var date2 = document.getElementById("date2").value;
          $.ajax({
            type: 'GET',
            url: $url,
            data: $("#byworker-form").serialize(), 
          });
          $(function() {
          $('#byworker-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
              "destroy": true,
              dom: 'Bfrtip',
                buttons: [
                {
                  extend: 'pageLength'
                },
                {
                  extend: 'copy',
                  title: 'Moley Boley | Gross Income Worker Breakdown'
                },
                {
                  extend: 'excel',
                  title: 'Moley Boley | Gross Income Worker Breakdown'
                },
                {
                  extend: 'pdf',
                  title: 'Moley Boley | Gross Income Worker Breakdown'
                },
                {
                  extend: 'print',
                  title: 'Moley Boley | Gross Income Worker Breakdown'
                },
                ],
            ajax:{ 
              url: '/grossincome/getbyworker?choice='+choice+'&worker_id='+worker_id+'&year='+year+'&month='+month+'&date1='+date1+'&date2='+date2+'',
              },
           /* drawCallback: function () {
            var api = this.api();
            $( api.table().footer(5) ).html(
            api.column(5).data().sum()
            );
            },*/
            columns: [
                {data: 'transactionno', name: 'transactionno', className: 'col-md-1 text-left', orderable: false},
                {data: 'workerno', name: 'workerno', className: 'col-md-1 text-left', orderable: false},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left', orderable: false},
                {data: 'datetime', name: 'datetime', className: 'col-md-1 text-left', orderable: false},
                {data: 'service', name: 'service', className: 'col-md-1 text-left', orderable: false},
                {data: 'grossincome', name: 'grossincome', className: 'col-md-1 text-left', orderable: false},
            ],
          });   
        }); 
          $("#byworker-table").show();
          
    });
   });  
</script>
</div>
@extends('layouts.footer')