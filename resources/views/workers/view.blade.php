	<div class="modal-dialog modal-s">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">WORKER DETAILS</h4>
        		</div>
        			<div class="modal-body" align="left"> 
        				<div class="container-fluid">

							<div class="row">
							<div class="col-sm-4"><strong>First Name:</strong>
							</div> 
							<div class="col-sm-4">{{$worker->workerfname}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Middle Name:</strong>
							</div> 
							<div class="col-sm-4">{{$worker->workermname}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Last Name:</strong>
							</div> 
							<div class="col-sm-4">{{$worker->workerlname}}</div>
							</div>

							
							<div class="row">
							<div class="col-sm-4"><strong>Birthdate:</strong>
							</div> 
							<div class="col-sm-4">{{ date('M d, Y', strtotime($worker->workerdbirth)) }}</div>
							</div>


							<div class="row">
							<div class="col-sm-4"><strong>Gender:</strong>
							</div> 
							<div class="col-sm-4">{{$worker->workergender}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Marital Status:</strong></div> 
							<div class="col-sm-4">{{$worker->workermaritalStatus}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Contact No:</strong></div> 
							<div class="col-sm-4">{{$worker->workerContactNo}}</div>
							</div>
							
							<div class="row">
							<div class="col-sm-4"><strong>Barangay:</strong></div> 
							<div class="col-sm-4">{{$worker->workerbrgy}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Town:</strong></div> 
							<div class="col-sm-4">{{$worker->workertown}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Province:</strong></div> 
							<div class="col-sm-4">{{$worker->workerprovince}}</div>
							</div>
							
							<div class="row">
							<div class="col-sm-4"><strong>Level:</strong></div> 
							<div class="col-sm-4">{{$worker->workerlevel}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Type:</strong></div> 
							<div class="col-sm-4">{{$worker->workertype}}</div>
							</div>
					</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
							</div>
						</div>	
					</div>
				</div>
			</div>	
