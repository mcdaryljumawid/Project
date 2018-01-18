
  <!-- Modal 
  <div class="modal fade" id="createModal" role="dialog" align="center-block">-->
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">ADD APPOINTMENT</h4>
        		</div>
        		<form class="form-horizontal" method="POST" action="/customer/storeappointment" id="add-appointments-form">
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Date and Time</label>
							<div class="col-sm-7">
					    		<input id="appointDateTime" type="datetime-local" class="form-control" name="appointDateTime" required autofocus>
								<span class="help-text text-danger"></span>
					  		</div>
						</div>

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
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        </div>

                      <div class="form-group">
        				<label class="col-xs-3 control-label">Terms and Conditions</label>
        	<div class="col-xs-9">
            <div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
                <p>Lorem ipsum dolor sit amet, veniam numquam has te. No suas nonumes recusabo mea, est ut graeci definitiones. His ne melius vituperata scriptorem, cum paulo copiosae conclusionemque at. Facer inermis ius in, ad brute nominati referrentur vis. Dicat erant sit ex. Phaedrum imperdiet scribentur vix no, ad latine similique forensibus vel.</p>
                <p>Dolore populo vivendum vis eu, mei quaestio liberavisse ex. Electram necessitatibus ut vel, quo at probatus oportere, molestie conclusionemque pri cu. Brute augue tincidunt vim id, ne munere fierent rationibus mei. Ut pro volutpat praesent qualisque, an iisque scripta intellegebat eam.</p>
                <p>Mea ea nonumy labores lobortis, duo quaestio antiopam inimicus et. Ea natum solet iisque quo, prodesset mnesarchum ne vim. Sonet detraxit temporibus no has. Omnium blandit in vim, mea at omnium oblique.</p>
                <p>Eum ea quidam oportere imperdiet, facer oportere vituperatoribus eu vix, mea ei iisque legendos hendrerit. Blandit comprehensam eu his, ad eros veniam ridens eum. Id odio lobortis elaboraret pro. Vix te fabulas partiendo.</p>
                <p>Natum oportere et qui, vis graeco tincidunt instructior an, autem elitr noster per et. Mea eu mundi qualisque. Quo nemore nusquam vituperata et, mea ut abhorreant deseruisse, cu nostrud postulant dissentias qui. Postea tincidunt vel eu.</p>
                <p>Ad eos alia inermis nominavi, eum nibh docendi definitionem no. Ius eu stet mucius nonumes, no mea facilis philosophia necessitatibus. Te eam vidit iisque legendos, vero meliore deserunt ius ea. An qui inimicus inciderint.</p>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-6 col-xs-offset-3">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="agree" value="1"/> Agree with the terms and conditions <span class="help-text text-danger"></span>            
                </label>
            </div>
        </div>
    </div>

		        		<div class="modal-footer">
		        			<div align="center">
		        				<div class="submit-btn btn btn-success">Add Appointment</div>
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
	        var $form = $('#add-appointments-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'POST',
	          url: $url,
	          data: $("#add-appointments-form").serialize(), 
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
		            $("#appointments-table").DataTable().ajax.url( '/customer/getpendingappointments' ).load();
	            $('.modal').modal('hide');
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
              url: "{{url('addappointment/select-service')}}/"+servicecategory,
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
                  url: "{{url('addappointment/select-worker')}}/"+service_id,
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