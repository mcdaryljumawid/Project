<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT CUSTOMER</h4>
        		</div>

        		<form class="form-horizontal" method="PATCH" action="/customers/{{$customer->id}}" id="edit-customers-form">
        			{{ csrf_field() }}
	        		<div class="modal-body">
						
	        			<div class="form-group">
							<label class="control-label col-sm-4">First Name</label>
							<div class="col-sm-7">
					    		<input id="custfname" type="text" class="form-control"  placeholder="First Name" name="custfname" value="{{$customer->custfname}}" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Middle Name</label>
							<div class="col-sm-7">
					    		<input id="custmname" type="text" class="form-control"  placeholder="Middle Name" name="custmname" value="{{$customer->custmname}}" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4">Last Name</label>
							<div class="col-sm-7">
					    		<input id="custlname" type="text" class="form-control"  placeholder="Last Name" name="custlname" value="{{$customer->custlname}}" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Username</label>
							<div class="col-sm-7">
					    		<input id="custUsername" type="text" class="form-control"  placeholder="User Name" name="custUsername" value="{{$customer->custUsername}}" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-7">
					    		<input id="password" type="password" class="form-control" placeholder="Password" name="password" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Confirm Password</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required>
								<span class="help-text text-danger"></span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-7">
					    		<form>
									<select class="select form-control" id="custgender" name="custgender" required>
									  <option value="Male" {{$customer->custgender == 'Male' ? 'selected':''}}>Male</option>
									  <option value="Female" {{$customer->custgender == 'Female' ? 'selected':''}}>Female</option>
									</select>
								</form>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Contact Number</label>
							<div class="col-sm-7">
					    		<input id="custContactNo" type="text" class="form-control"  placeholder="Contact Number" name="custContactNo" value="{{$customer->custContactNo}}" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Email</label>
							<div class="col-sm-7">
					    		<input id="email" type="text" class="form-control"  placeholder="email@example.com" name="email" value="{{$customer->email}}" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

			        	<div class="modal-footer">
		        			<div align="center">
								<div class="update-btn btn btn-success">Update Customer</div>

								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
		        	</div>
		     </form>
	 </div>
</div>

<script type="text/javascript">
	$(function(){
		$(document).off('click','.update-btn').on('click','.update-btn', function(e){
	    	e.preventDefault();
	        var $form = $('#edit-customers-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#edit-customers-form").serialize(), 
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
	            $("#customers-table").DataTable().ajax.url( '/customers/get_datatable' ).load();
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
