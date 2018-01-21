
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD APPOINTMENT</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/customer/storeappointment" id="add-appointments-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Date and Time</label>
							<div class="col-sm-7">
					    		<input id="appointDateTime" type="datetime-local" class="form-control" name="appointDateTime" required autofocus>
								<span class="help-text text-danger"></span>
					  		</div>
						</div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Service Category</label>
                            <div class="col-sm-7">
                                <select class="select form-control " id="select_servicecategory" name="servicecategory" style="width: 200px">
                                    <option value="Hair">Hair</option>
                                    <option value="Threading">Threading</option>
                                    <option value="Nails">Nails</option>
                                    <option value="SPA">SPA</option>
                                    <option value="Eyelash">Eyelash</option>
                                    <option value="Waxing">Waxing</option>
                                    <option value="Massage">Massage</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Service</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="service_id" name="service_id" style="width: 200px">
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Worker</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="worker_id" name="worker_id" style="width: 200px">
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                      <div class="form-group">
        				<label class="col-xs-3 control-label">Terms and Conditions</label>
        	<div class="col-xs-9">
            <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
                <p>These terms and conditions are provided to propose rules and policies in relation with the Online Appointment of Services offered by Moley Boley Galleria Luisa.</p>
                <p>Appointments are to be booked 3 hours before the desired time of appointment. For Rebond, which usually takes for 6 hours, it must be booked 24 hours or 1 day before the desired appointment time.</p>
                <p>Timeslot chosen by the user may be in conflict under the following possibilities: (1) Worker chosen has an existing appointment on which the forcasted time range is in conflict with the time chosen by the client. (2) Chosen timeslot might be out of the operation hours. (3) Date is beyond the present date.</p>
                <p>Moley Boley Operation Hours:
                  Monday to Saturday:   9am to 9pm
                  Sunday:               10am to 9pm
                </p>
                <p>Reschedule and cancellation of appointment must be done 3 hours before the appointment. The same possibilities of conflict are provided for reschedule and cancellation.</p>
                <p>Upon arriving at Moley Boley, the client must present a valid ID certifying that he/she is the one with current pending appointment for that time.</p>
                <p>Appointments can be cancelled by the cashier or manager if customer doesn't show up in time chosen by the user.</p>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="agree" value="1"/> Agree with the terms and conditions <span class="help-text text-danger"></span>            
                </label>
            </div>
        </div>
    </div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add Appointment</div>
								<!-- <button type="submit" class="btn btn-primary">Add User</button> -->
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>

		        	</div>
		        </form>
		     </div>
		</div>

<script type="text/javascript">
	$(function(){
		$(document).off('click','.submit-btn').on('click','.submit-btn', function(e){
	    	e.preventDefault();
	        var $form = $('#add-appointments-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-appointments-form").serialize(), 
	          success: function(result){
		            if(result.success){
		              swal({
		                  title: result.msg,
		                  icon: "success"
		                });
                  $("#appointments-table").DataTable().ajax.url( '/customer/getpendingappointments' ).load();
                  $('.modal').modal('hide');
		            }else{
		              swal({
		                  title: result.msg,
		                  icon: "error"
		                });
		            }
	          },
	          error: function(xhr,status,error){
	            var response_object = JSON.parse(xhr.responseText); 
	            associate_errors(response_object.errors, $form);
	          }
	        });
		});
	 });

    $('#select_servicecategory').change(function(){
      var servicecategory = $(this).val();
      var that = this;
      var token = $("input[name='_token']").val();
      $.ajax({
              url: "{{url('addappointment/select-service')}}/"+servicecategory,
              method: 'GET',
              success: function(data) {
                $("select[name='service_id'").html('');
                $("select[name='service_id'").html(data);
              }
          });
      });
    $('#select_servicecategory').change();

    function getWorkers(){
        $('#service_id').change(function(){
          var service_id = $(this).val();
          var that = this;
          var token = $("input[name='_token']").val();
          $.ajax({
                  url: "{{url('addappointment/select-worker')}}/"+service_id,
                  method: 'GET',
                  success: function(data) {
                    $("select[name='worker_id'").html('');
                    $("select[name='worker_id'").html(data);
                  }
              });    
          });
    }
    getWorkers();
</script>