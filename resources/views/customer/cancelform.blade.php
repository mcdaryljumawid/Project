
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">CANCEL APPOINTMENT</h4>
        		</div>

        		<form class="form-horizontal" method="PATCH" action="/customer/{{ $appointment->id }}/cancel" id="cancel-appointments-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Remarks (Reason for appointment cancellation)</label>
							<div class="col-sm-7">
					    		<input id="appointRemarks" type="text" class="form-control" name="appointRemarks" required autofocus value="{{ $appointment->appointRemarks }}"><span class="help-text text-danger"></span>
					    		<input id="appointStatus" type="hidden" class="form-control" name="appointStatus" required autofocus value="{{ $appointment->appointStatus }}">
					  		</div>
						</div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Cancel Appointment</div>
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
	        var $form = $('#cancel-appointments-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#cancel-appointments-form").serialize(), 
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
	            $("#appointments-table").DataTable().ajax.url( '/customer/getpendingappointments' ).load();
	            $("#master-appointments-table").DataTable().ajax.url( '/customer/getappointments' ).load();
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