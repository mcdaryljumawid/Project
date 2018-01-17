	<div class="modal-dialog modal-m">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">APPOINTMENT DETAILS</h4>
        		</div>

        		<div class="form-group">
        			<div class="modal-body" align="left" style="padding-left: 50px"> 
							<div class="col-sm-4"><strong>Date and Time:</strong></div> 
							<div class="col-sm-5">{{ date('M d, Y h:i A', strtotime($appointment->appointDateTime)) }}</div>

							<div class="col-sm-4"><strong>Re-schedule until:</strong></div> 
							<div class="col-sm-7">{{ date('M d, Y h:i A', strtotime($appointment->datetimeResched)) }}</div>

							<br><br><br>

							<div class="col-sm-4"><strong><i>Customer</i></strong></div><br>
							<div class="col-sm-4"><strong>Lastname:</strong></div> 
							<div class="col-sm-7">{{$appointment->customer->custlname}}</div>

							<div class="col-sm-4"><strong>Firstname:</strong></div> 
							<div class="col-sm-7">{{$appointment->customer->custfname}}</div>

							<br><br><br>

							<div class="col-sm-4"><strong><i>Worker Assigned</i></strong></div><br>
							<div class="col-sm-4"><strong>Lastname:</strong></div> 
							<div class="col-sm-7">{{$appointment->worker->workerlname}}</div>

							<div class="col-sm-4"><strong>Firstname:</strong></div> 
							<div class="col-sm-7">{{$appointment->worker->workerfname}}</div>

							<br><br><br>

							<div class="col-sm-4"><strong><i>Service availed</i></strong></div> <br>
							<div class="col-sm-4"><strong>Service:</strong></div>
							<div class="col-sm-7">{{$appointment->service->servicename}}</div>

							<div class="col-sm-4"><strong>Price:</strong></div> 
							<div class="col-sm-7">{{$appointment->service->serviceprice}}</div>	<br>

							<div class="col-sm-4"><strong>Remarks:</strong></div> 
							<div class="col-sm-7">{{$APPOINTMENT->appointRemarks}}</div>	<br>
						</div>	
					</div>
				</div>
			</div>		
