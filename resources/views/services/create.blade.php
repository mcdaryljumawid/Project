    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD NEW SERVICE</h4>
        		</div>

        		<form class="form-horizontal" method="POST" action="/services" id="add-services-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Service Name</label>
							<div class="col-sm-7">
					    		<input id="servicename" type="text" class="form-control"  placeholder="Service Name" name="servicename" required autofocus>
					    		<span class="help-text text-danger"></span>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Price</label>
							<div class="col-sm-7">
				    			<input id="serviceprice" type="text" class="form-control"  placeholder="Service Price" name="serviceprice" required autofocus>
				    			<span class="help-text text-danger"></span>	
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Duration</label>
							<div class="col-sm-7">
				  				<input  id="serviceduration" type="text" class="form-control"  placeholder="Service duration" name="serviceduration" required autofocus>
				  				<span class="help-text text-danger"></span>
							</div>
						</div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Service Type</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="servicetype" name="servicetype" style="width: 200px">
                                	<option value="Major">Major</option>
                                    <option value="Minor">Minor</option>
                                </select>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
								<div class="submit-btn btn btn-success">Add Service</div>

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
	        var $form = $('#add-services-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-services-form").serialize(), 
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

