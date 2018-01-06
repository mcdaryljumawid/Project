	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT WORKER</h4>
        		</div>

        		<form class="form-horizontal" method="PATCH" action="/workers/{{$worker->id}}" id="edit-workers-form">
					{{ csrf_field() }}
        			<div class="modal-body">

	        			<div class="form-group">
							<label class="control-label col-sm-4">First Name</label>
							<div class="col-sm-7">
					    		<input id="workerfname" type="text" class="form-control"  placeholder="First Name" name="workerfname" required autofocus value="{{$worker->workerfname}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Middle Name</label>
							<div class="col-sm-7">
					    		<input id="workermname" type="text" class="form-control"  placeholder="Middle Name" name="workermname" required autofocus value="{{$worker->workermname}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Last Name</label>
							<div class="col-sm-7">
					    		<input id="workerlname" type="text" class="form-control"  placeholder="Last Name" name="workerlname" required autofocus value="{{$worker->workerlname}}">
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
					    		<input id="workerdbirth" type="date" class="form-control"  placeholder="Date of Birth" name="workerdbirth" required autofocus value="{{$worker->workerdbirth}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workergender" name="workergender" style="width: 200px" required>
									  <option value="Male"  {{$worker->workergender == 'Male' ? 'selected':''}}>Male</option>
									  <option value="Female"  {{$worker->workergender == 'Female' ? 'selected':''}}>Female</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Marital Status</label>
							<div class="col-sm-7">
							        <select class="select form-control" id="workermaritalStatus" name="workermaritalStatus" style="width: 200px" required>
									  <option value="Single" {{$worker->workermaritalStatus == 'Single' ? 'selected':''}}>Single</option>
									  <option value="Married" {{$worker->workermaritalStatus == 'Married' ? 'selected':''}}>Married</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Contact Number</label>
							<div class="col-sm-7">
					    		<input id="workerContactNo" type="text" class="form-control" placeholder="Contact No" name="workerContactNo" required autofocus value="{{$worker->workerContactNo}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Barangay</label>
							<div class="col-sm-7">
					    		<input id="workerbrgy" type="text" class="form-control" placeholder="Barangay" name="workerbrgy" required autofocus value="{{$worker->workerbrgy}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Town</label>
							<div class="col-sm-7">
					    		<input id="workertown" type="text" class="form-control"  placeholder="Town" name="workertown" required autofocus value="{{$worker->workertown}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Province</label>
							<div class="col-sm-7">
					    		<input id="workerprovince" type="text" class="form-control"  placeholder="Province" name="workerprovince" required autofocus value="{{$worker->workerprovince}}">
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
							
						<div class="form-group">
							<label class="control-label col-sm-4">Level</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workerlevel" name="workerlevel" style="width: 200px" required autofocus>
									  <option value="High" {{$worker->workerlevel == 'High' ? 'selected':''}}>High</option>
									  <option value="Low" {{$worker->workerlevel == 'Low' ? 'selected':''}}>Low</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Type</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workertype" name="workertype" style="width: 200px" required>
									  <option value="Barber" {{$worker->workertype == 'Barber' ? 'selected':''}}>Barber</option>
									  <option value="All-around (Rebond specialized)"  {{$worker->workertype == 'All-around (Rebond specialized)' ? 'selected':''}}>All-around (Rebond specialized)</option>
									  <option value="All-around (Haircut specialized)" {{$worker->workertype == 'All-around (Haircut specialized)' ? 'selected':''}}>All-around (Haircut specialized)</option>
									</select>
									<span class="help-text text-danger"></span>
					  		</div>
						</div>

	        			<div class="modal-footer">
		        			<div align="center">
		        				<div class="update-btn btn btn-success">Update Worker</div>
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
		$(document).off('click','.update-btn').on('click','.update-btn', function(e){
	    	e.preventDefault();
	        var $form = $('#edit-workers-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#edit-workers-form").serialize(), 
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
