	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD NEW WORKER</h4>
        		</div>

        		<form class="form-horizontal" method="POST" action="/workers" id="add-workers-form">
					{{ csrf_field() }}
        			<div class="modal-body">

	        			<div class="form-group">
							<label class="control-label col-sm-4">First Name</label>
							<div class="col-sm-7">
					    		<input id="workerfname" type="text" class="form-control"  placeholder="First Name" name="workerfname" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Middle Name</label>
							<div class="col-sm-7">
					    		<input id="workermname" type="text" class="form-control"  placeholder="Middle Name" name="workermname" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Last Name</label>
							<div class="col-sm-7">
					    		<input id="workerlname" type="text" class="form-control"  placeholder="Last Name" name="workerlname" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
					    		<input id="password" type="password" class="form-control"  placeholder="Password" name="password" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Confirm Password</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="confirm_password" placeholder="Password" name="confirm_password" required>
								<span class="help-text text-danger"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Date of Birth</label>
							<div class="col-sm-7">
					    		<input id="workerdbirth" type="date" class="form-control"  placeholder="Date of Birth" name="workerdbirth" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workergender" name="workergender" style="width: 200px" required>
									  <option value="Male">Male</option>
									  <option value="Female">Female</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Marital Status</label>
							<div class="col-sm-7">
							        <select class="select form-control" id="workermaritalStatus" name="workermaritalStatus" style="width: 200px" required>
									  <option value="Single">Single</option>
									  <option value="Married">Married</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Contact Number</label>
							<div class="col-sm-7">
					    		<input id="workerContactNo" type="text" class="form-control" placeholder="Contact No" name="workerContactNo" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Barangay</label>
							<div class="col-sm-7">
					    		<input id="workerbrgy" type="text" class="form-control" placeholder="Barangay" name="workerbrgy" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Town</label>
							<div class="col-sm-7">
					    		<input id="workertown" type="text" class="form-control"  placeholder="Town" name="workertown" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Province</label>
							<div class="col-sm-7">
					    		<input id="workerprovince" type="text" class="form-control"  placeholder="Province" name="workerprovince" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
							
						<div class="form-group">
							<label class="control-label col-sm-4">Level</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workerlevel" name="workerlevel" style="width: 200px" required autofocus>
									  <option value="High">High</option>
									  <option value="Low">Low</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Type</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workertype" name="workertype" style="width: 200px" required>
									  <option value="Barber">Barber</option>
									  <option value="All-around (Rebond specialized)">All-around (Rebond specialized)</option>
									  <option value="All-around (Haircut specialized)">All-around (Haircut specialized)</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<input id="status" type="hidden" class="form-control" name="status" value="Active">
						</div>

						<div class="form-group">
							<input id="availability" type="hidden" class="form-control" name="availability" value="1">
						</div>

	        			<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add Worker</div>
								<!--<button type="submit" class="btn btn-primary">Add Worker</button>-->
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
		        	</div>
		        </form>
		     </div>
		</div>
	</div>

<script type="text/javascript">
	$(function(){
		$(document).off('click','.submit-btn').on('click','.submit-btn', function(e){
	    	e.preventDefault();
	        var $form = $('#add-workers-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-workers-form").serialize(), 
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
	            $("#workers-table").DataTable().ajax.url( '/workers/get_datatable' ).load();
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
