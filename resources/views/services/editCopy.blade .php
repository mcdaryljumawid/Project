  <!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog" align="center-block">
    	<div class="modal-dialog">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">EDIT SERVICE</h4>
        		</div>

        		<form class="form-horizontal" method="POST" action="/services">
        			{{ method_field('PUT') }}
					{{ csrf_field() }}
        			<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-sm-4">Service Name</label>
							<div class="col-sm-7">
					    		<input id="servicename" type="text" class="form-control"  placeholder="Service Name" name="servicename" value="{{ old('servicename') }}" required autofocus>
					  		</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Price</label>
							<div class="col-sm-7">
				    			<input id="serviceprice" type="text" class="form-control"  placeholder="Service Price" name="serviceprice" required autofocus>	
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-4">Service Duration</label>
							<div class="col-sm-7">
				  				<input  id="serviceduration" type="text" class="form-control"  placeholder="Service duration" name="serviceduration" required autofocus>
							</div>
						</div>

						<div class="form-group">
                            <label class ="control-label col-sm-4">Service Type</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="role" name="role" style="width: 200px">
                                	<option value="Major">Major</option>
                                    <option value="Minor">Ca</option>
                                </select>
                            </div>
                        </div>

		        		<div class="modal-footer">
		        			<div align="center">
								<button type="submit" class="btn btn-primary">Add Service</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
		        	</div>
		        </form>
		     </div>
		</div>
	</div>

