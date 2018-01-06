  <!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog" align="center-block">
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT NEW WORKER</h4>
        		</div>

        		<form class="form-horizontal" method="POST" action="/workers">
					{{ method_field('PUT') }}
					{{ csrf_field() }}

        			<div class="modal-body">

	        			<div class="form-group">
							<label class="control-label col-sm-4">First Name</label>
							<div class="col-sm-7">
					    		<input id="workerfname" type="text" class="form-control"  placeholder="First Name" name="workerfname" required autofocus>
					  		</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Middle Name</label>
							<div class="col-sm-7">
					    		<input id="workermname" type="text" class="form-control"  placeholder="Middle Name" name="workermname" required autofocus>
					  		</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Last Name</label>
							<div class="col-sm-7">
					    		<input id="workerlname" type="text" class="form-control"  placeholder="Last Name" name="workerlname" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
					    		<input id="password" type="password" class="form-control"  placeholder="Password" name="password" required autofocus>
					  		</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Date of Birth</label>
							<div class="col-sm-7">
					    		<input id="workerdbirth" type="date" class="form-control"  placeholder="Date of Birth" name="workerdbirth" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workergender" name="workergender" style="width: 200px" required>
									  <option value="Male">Male</option>
									  <option value="Female">Female</option>
									</select>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Marital Status</label>
							<div class="col-sm-7">
							        <select class="select form-control" id="workermaritalStatus" name="workermaritalStatus" style="width: 200px" required>
									  <option value="Single">Single</option>
									  <option value="Married">Married</option>
									</select>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Contact Number</label>
							<div class="col-sm-7">
					    		<input id="workerContactNo" type="text" class="form-control" placeholder="Contact No" name="workerContactNo" required autofocus>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Barangay</label>
							<div class="col-sm-7">
					    		<input id="workerbrgy" type="text" class="form-control" placeholder="Barangay" name="workerbrgy" required autofocus>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Town</label>
							<div class="col-sm-7">
					    		<input id="workertown" type="text" class="form-control"  placeholder="Town" name="workertown" required autofocus>
					  		</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Province</label>
							<div class="col-sm-7">
					    		<input id="workerprovince" type="text" class="form-control"  placeholder="Province" name="workerprovince" required autofocus>
					  		</div>
						</div>
							
						<div class="form-group">
							<label class="control-label col-sm-4">Level</label>
							<div class="col-sm-7">
									<select class="select form-control" id="workerlevel" name="workerlevel" style="width: 200px" required autofocus>
									  <option value="High">High</option>
									  <option value="Low">Low</option>
									</select>
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
					  		</div>
						</div>

	        			<div class="modal-footer">
		        			<div align="center">
								<button type="submit" class="btn btn-primary">Edit Worker</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
		        	</div>
		        </form>
		     </div>
		</div>
	</div>

