 <!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog" align="center-block">
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT USER</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/users">
					{{ method_field('PUT') }}
					{{ csrf_field() }}

        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">First name</label>
							<div class="col-sm-7">
					    		<input id="firstname" type="text" class="form-control"  placeholder="First Name" name="firstname" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Middle name</label>
							<div class="col-sm-7">
				    			<input id="middlename" type="text" class="form-control"  placeholder="Middle Name" name="middlename" required autofocus>	
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Last name</label>
							<div class="col-sm-7">
				  				<input  id="lastname" type="text" class="form-control"  placeholder="Last Name" name="lastname" required autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
							</div>
						</div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Role</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="role" name="role" style="width: 200px">
                                	<option value="Manager">Manager</option>
                                    <option value="Cashier">Cashier</option>
                                </select>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
								<button type="submit" class="btn btn-primary">Edit User</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>

		        	</div>
		        </form>
		     </div>
		</div>
	</div>

