@extends('layouts.master')
<!--@include('script')-->
@section('title')
	Worker Performance | Moley Boley Online Appointment and Operations Management System
@endsection
@include('script')
<br><br><br>
<div class="container">
 <form class="form-horizontal" method="GET" action="/reports/getworkerperformance" id="workerperformance-form">
  
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
  <button class="submit-btn btn btn-success">View worker performance</button>
</div>
</div>

<div>
<table id="workerperformance-table" class="table" style="font-size: 15px; display:none;">
  <thead style="font-weight: bold;">
    <tr>
        <td>Service ID</td>
        <td>Service Name</td>
        <td>Number of Transactions</td>
        <td>Worker name</td>
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
    $(document).off('click','.submit-btn').on('click','.submit-btn', function(e){
        e.preventDefault();
          var $form = $('#workerperformance-form');
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
            data: $("#workerperformance-form").serialize(), 
          });
          $(function() {
          $('#workerperformance-table').DataTable({
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
                  title: 'Moley Boley | Worker Performance'
                },
                {
                  extend: 'excel',
                  title: 'Moley Boley | Worker Performance'
                },
                {
                  extend: 'pdf',
                  title: 'Moley Boley | Worker Performance'
                },
                {
                  extend: 'print',
                  title: 'Moley Boley | Worker Performance'
                },
                ],
            ajax:{ 
              url: '/reports/getworkerperformance?choice='+choice+'&worker_id='+worker_id+'&year='+year+'&month='+month+'&date1='+date1+'&date2='+date2+'',
              },
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left', orderable: false},
                {data: 'servicename', name: 'servicename', className: 'col-md-1 text-left', orderable: false},
                {data: 'transactioncount', name: 'transactioncount', className: 'col-md-1 text-left', orderable: false},
                {data: 'workername', name: 'workername', className: 'col-md-1 text-left', orderable: false},
            ],
          });   
        }); 

          //$("#grossincome-table").DataTable().ajax.url('/grossincome/getgrossincome').load(); 
          $("#workerperformance-table").show();
          
    });
   });  
</script>
</div>
@extends('layouts.footer')