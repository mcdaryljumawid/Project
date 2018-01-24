
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD TRANSACTION</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/transactions" id="add-transactions-form">
					{{ csrf_field() }}
        			<div class="modal-body">

        				<div class="form-group">
                            <label class ="control-label col-sm-4">Service Category</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="select_servicecategory" name="servicecategory" style="width: 200px">
                                	<option value="Hair">Hair</option>
                                    <option value="Threading">Threading</option>
                                    <option value="Nails">Nails</option>
                                    <option value="SPA">SPA</option>
                                    <option value="Eyelash">Eyelash</option>
                                    <option value="Waxing">Waxing</option>
                                    <option value="Massage">Massage</option>
                                </select>
                            </div>
                        </div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Service</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="service_id" name="service_id" style="width: 200px">
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Worker</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="worker_id" name="worker_id" style="width: 200px">
                            		<option disabled selected><i>Choose a worker</i></option>
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Customer</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="customer_id" name="customer_id" style="width: 200px">
                            		@foreach($customers as $customer)
                                		<option value="{{ $customer->id }}">{{ $customer->custlname }}, {{ $customer->custfname }}</option>
                                	@endforeach
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add Transaction</div>
								<!-- <button type="submit" class="btn btn-primary">Add User</button> -->
								<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
	        var $form = $('#add-transactions-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-transactions-form").serialize(), 
	          success: function(result){
		            if(result.success){
		              swal({
		                  title: result.msg,
		                  icon: "success"
		                });
		               $("#transactions-table").DataTable().ajax.url( '/transactions/get_datatable' ).load();
	            	   $('.modal').modal('hide');
		            }else{
		              swal({
		                  title: result.msg,
		                  icon: "error"
		                });
		            }
	          },
	          error: function(xhr,status,error){
	            var response_object = JSON.parse(xhr.responseText); 
	            associate_errors(response_object.errors, $form);
	          }
	        });
		});
	 });

	$('#select_servicecategory').change(function(){
      var servicecategory = $(this).val();
      var that = this;
      var token = $("input[name='_token']").val();
      $.ajax({
	          url: "{{url('select-service')}}/"+servicecategory,
	          method: 'GET',
	          success: function(data) {
	            $("select[name='service_id'").html('');
	            $("select[name='service_id'").html(data);
	          }
	      });
	  });
	 $('#select_servicecategory').change();
	

	function getWorkers(){
		$('#service_id').change(function(){
	      var service_id = $(this).val();
	      var that = this;
	      var token = $("input[name='_token']").val();
	      $.ajax({
		          url: "{{url('select-worker')}}/"+service_id,
		          method: 'GET',
		          success: function(data) {
		            $("select[name='worker_id'").html('');
		            $("select[name='worker_id'").html(data);
		          }
		      });
		      
		  });
	}
	getWorkers();
</script>