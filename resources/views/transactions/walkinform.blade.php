
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD WALK-IN TRANSACTION</h4>
        		</div>
        		<form class="form-horizontal" method="PATCH" action="/transactions_addwalkin" id="add-walkin-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
                        <input type="hidden" id="customer_id" name="customer_id" value="1">       
                    	</div>

                    	<div class="form-group">
                            <label class ="control-label col-sm-4">Service Category</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="select_servicecategory_walkin" name="servicecategory" style="width: 200px">
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
                            	<select class="select form-control " id="service_id_walkin" name="service_id" style="width: 200px">
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class ="control-label col-sm-4">Worker</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="worker_id_walkin" name="worker_id" style="width: 200px">
                            		<option disabled selected><i>Choose a worker</i></option>
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
	        var $form = $('#add-walkin-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#add-walkin-form").serialize(), 
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

	$('#select_servicecategory_walkin').change(function(){
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
	 $('#select_servicecategory_walkin').change();
	

		$('#service_id_walkin').change(function(){
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
		$('#service_id_walkin').change();
</script>