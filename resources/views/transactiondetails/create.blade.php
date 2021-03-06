
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD TRANSACTION DETAILS</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/transactiondetails" id="add-transactiondetails-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
                            <label class ="control-label col-sm-4">Service</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="service_id" name="service_id" style="width: 200px">
                            		@foreach($services as $service)
                                		<option value="{{ $service->id }}">{{ $service->servicename }}</option>
                                	@endforeach
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Worker</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="worker_id" name="worker_id" style="width: 200px">
                            		@foreach($workers as $worker)
                                		<option value="{{ $worker->id }}">{{ $worker->workerlname }}, {{ $worker->workerfname }}</option>
                                	@endforeach
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                        
                        <div class="form-group">	
					    		<input id="transaction_id" type="hidden" class="form-control" name="transaction_id" required autofocus>
						</div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add Transaction Details</div>
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
	        var $form = $('#add-transactiondetails-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-transactiondetails-form").serialize(), 
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
		            //$("#transactions-table").DataTable().ajax.url( '/transactions/get_datatable' ).load();
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