	<div class="modal-dialog modal-m">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">WORKER DETAILS</h4>
        		</div>

        		<div class="form-group">
        			<div class="modal-body" align="left" style="padding-left: 170px"> 
							
							<div class="col-sm-4"><strong>First Name:</strong></div> 
							<div class="col=sm-7">{{$worker->workerfname}}</div>

							<div class="col-sm-4"><strong>Middle Name:</strong></div> 
							<div class="col=sm-7">{{$worker->workermname}}</div>

							<div class="col-sm-4"><strong>Last Name:</strong></div> 
							<div class="col=sm-7">{{$worker->workerlname}}</div>

							<br>

							<div class="col-sm-4"><strong>Date of Birth:</strong></div> 
							<div class="col=sm-7">{{$worker->workerdbirth}}</div>

							<div class="col-sm-4"><strong>Gender:</strong></div> 
							<div class="col=sm-7">{{$worker->workergender}}</div>

							<div class="col-sm-4"><strong>Marital Status:</strong></div> 
							<div class="col=sm-7">{{$worker->workermaritalStatus}}</div>

							<div class="col-sm-4"><strong>Contact No:</strong></div> 
							<div class="col=sm-7">{{$worker->workerContactNo}}</div>

							<br>

							<div class="col-sm-4"><strong>Barangay:</strong></div> 
							<div class="col=sm-7">{{$worker->workerbrgy}}</div>

							<div class="col-sm-4"><strong>Town:</strong></div> 
							<div class="col=sm-7">{{$worker->workertown}}</div>

							<div class="col-sm-4"><strong>Province:</strong></div> 
							<div class="col=sm-7">{{$worker->workerprovince}}</div>
						
							<br>

							<div class="col-sm-4"><strong>Level:</strong></div> 
							<div class="col=sm-7">{{$worker->workerlevel}}</div>

							<div class="col-sm-4"><strong>Type:</strong></div> 
							<div class="col=sm-7">{{$worker->workertype}}</div>
						</div>	
					</div>
				</div>
			</div>		
