 <button type="button" class="btn btn-success btn-default" data-toggle="modal" data-target="#createCustomerModal">Add Customer</button>
  <!-- Modal -->
  <div class="modal fade" id="createCustomerModal" role="dialog" align="center-block">
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD CUSTOMER</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/customers">
        			{{ csrf_field() }}
	        		<div class="modal-body">
						
	        			<div class="form-group">
							<label class="control-label col-sm-4">First Name</label>
							<div class="col-sm-7">
					    		<input id="custfname" type="text" class="form-control"  placeholder="First Name" name="custfname" required autofocus>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Middle Name</label>
							<div class="col-sm-7">
					    		<input id="custmname" type="text" class="form-control"  placeholder="Middle Name" name="custmname" required autofocus>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Last Name</label>
							<div class="col-sm-7">
					    		<input id="custlname" type="text" class="form-control"  placeholder="Last Name" name="custlname" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Username</label>
							<div class="col-sm-7">
					    		<input id="custUsername" type="text" class="form-control"  placeholder="User Name" name="custUsername" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
					    		<input id="password" type="password" class="form-control" name="password" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-7">
					    		<form>
									<select class="select form-control" id="custgender" name="custgender" required>
									  <option value="Male">Male</option>
									  <option value="Female">Female</option>
									</select>
								</form>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Contact Number</label>
							<div class="col-sm-7">
					    		<input id="custContactNo" type="text" class="form-control"  placeholder="Contact Number" name="custContactNo" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Email</label>
							<div class="col-sm-7">
					    		<input id="email" type="text" class="form-control"  placeholder="email@example.com" name="email" required autofocus>
					  		</div>
						</div>

			        	<div class="modal-footer">
		        			<div align="center">
								<button type="submit" class="btn btn-primary">Add Customer</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
		        	</div>
		        </form>
		     </div>
		</div>
	</div>

