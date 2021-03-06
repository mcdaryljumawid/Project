    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT SERVICE</h4>
        		</div>

        		<form class="form-horizontal" method="PATCH" action="/services/{{$service->id}}" id="edit-services-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Service Name</label>
							<div class="col-sm-7">
					    		<input id="servicename" type="text" class="form-control"  placeholder="Service Name" name="servicename" value="{{$service->servicename}}" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Price</label>
							<div class="col-sm-7">
				    			<input id="serviceprice" type="text" class="form-control"  placeholder="Service Price" name="serviceprice" value="{{$service->serviceprice}}" required autofocus>	
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Duration</label>
							<div class="col-sm-7">
				  				<input  id="serviceduration" type="text" class="form-control"  placeholder="Service duration" name="serviceduration" value="{{$service->serviceduration}}" required autofocus>
							</div>
						</div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Service Type</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="servicetype" name="servicetype" style="width: 200px">
                                	<option value="Major" {{$service->servicetype == 'Major' ? 'selected':''}}>Major</option>
                                    <option value="Minor" {{$service->servicetype == 'Minor' ? 'selected':''}}>Minor</option>
                                </select>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class ="control-label col-sm-4">Service Category</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="servicecategory" name="servicecategory" style="width: 200px">
                                	<option value="Hair" {{$service->servicecategory == 'Hair' ? 'selected':''}}>Hair</option>
                                    <option value="Threading" {{$service->servicecategory == 'Threading' ? 'selected':''}}>Threading</option>
                                    <option value="Nails" {{$service->servicecategory == 'Nails' ? 'selected':''}}>Nails</option>
                                    <option value="SPA" {{$service->servicecategory == 'SPA' ? 'selected':''}}>SPA</option>
                                    <option value="Eyelash" {{$service->servicecategory == 'Eyelash' ? 'selected':''}}>Eyelash</option>
                                    <option value="Waxing" {{$service->servicecategory == 'Waxing' ? 'selected':''}}>Waxing</option>
                                    <option value="Massage" {{$service->servicecategory == 'Massage' ? 'selected':''}}>Massage</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Status</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="status" name="status" style="width: 200px">
                                	<option value="Active" {{$service->status == 'Active' ? 'selected':''}}>Active</option>
                                    <option value="Inactive" {{$service->status == 'Inactive' ? 'selected':''}}>Inactive</option>
                                </select>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
								<div class="update-btn btn btn-success">Update Service</div>

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
	        var $form = $('#edit-services-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#edit-services-form").serialize(), 
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
	            $("#services-table").DataTable().ajax.url( '/services/get_datatable' ).load();
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

