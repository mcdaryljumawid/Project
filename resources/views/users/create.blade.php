
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD NEW USER</h4>
        		</div>

        		<form class="form-horizontal" method="POST" action="/users" id="add-users-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">First name</label>
							<div class="col-sm-7">
					    		<input id="firstname" type="text" class="form-control"  placeholder="First Name" name="firstname" value="{{ old('firstname') }}" required autofocus>
								<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Middle name</label>
							<div class="col-sm-7">
				    			<input id="middlename" type="text" class="form-control"  placeholder="Middle Name" name="middlename" required autofocus>
								<span class="help-text text-danger"></span>	
							</div>
                            
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Last name</label>
							<div class="col-sm-7">
				  				<input  id="lastname" type="text" class="form-control"  placeholder="Last Name" name="lastname" required autofocus>
								<span class="help-text text-danger"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
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
                            <label class ="control-label col-sm-4">Role</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="role" name="role" style="width: 200px">
                                	<option value="Manager">Manager</option>
                                    <option value="Cashier">Cashier</option>
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add User</div>
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
	        var $form = $('#add-users-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-users-form").serialize(), 
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
	            $("#users-table").DataTable().ajax.url( '/users/get_datatable' ).load();
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