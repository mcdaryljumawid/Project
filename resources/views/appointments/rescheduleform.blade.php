
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">RESCHEDULE APPOINTMENT</h4>
        		</div>

        		<form class="form-horizontal" method="PATCH" action="/appointments/{{ $appointment->id }}" id="reschedule-appointments-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Date and Time </label>
							<div class="col-sm-7">
					    		<input id="appointDateTime" type="datetime-local" class="form-control" name="appointDateTime" required autofocus value="{{ date('Y-m-d', strtotime($appointment->appointDateTime)).'T'.date('H:m:s', strtotime($appointment->appointDateTime)) }}">
					  		</div>
						</div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Re-schedule Appointment</div>
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
	        var $form = $('#reschedule-appointments-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#reschedule-appointments-form").serialize(), 
	          success: function(result){
	            if(result.success){
	              swal({
	                  title: result.msg,
	                  icon: "success"
	                });
	            }else{
	              swal({
	                  title: result.msg,
	                  icon: "error"
	                });
	            }
	            $("#appointments-table").DataTable().ajax.url( '/appointments/get_datatable' ).load();
	            $('.modal').modal('hide');
	          },
	          error: function(xhr,status,error){
	            var response_object = JSON.parse(xhr.responseText); 
	            associate_errors(response_object.errors, $form);
	          }
	        });
		});
	 });  
</script>