@extends('layouts.master')
<!--@include('script')-->
@section('title')
	Gross Income | Moley Boley Online Appointment and Operations Management System
@endsection
@include('script')
<br><br><br>
<div class="container">
  <div class="row">

    <form class="form-horizontal" method="POST" action="/workers" id="add-workers-form">
    {{ csrf_field() }}
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
    </form>
  </div>

  <div class="row">
      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <select name="year" id="year" class="form-control" style="display:none;">
            @for ($i=2018; $i >= 2000; $i--)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select>
        </div>
      </div>

      <div class = "col-md-2">
        <div class = "form-group">
          <select name="month" id="month" class="form-control" style="display:none;">
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
    </form>
  </div>

  <div class="row">
      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <input type="date" name="date1" id="date1" class="form-control" style="display:none;">
        </div>
      </div>

      <div class = "col-md-2 col-md-offset-1">
        <div class = "form-group">
          <input type="date" name="date2" id="date2" class="form-control" style="display:none;">
        </div>
      </div>
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
</script>
</div>
@extends('layouts.footer')