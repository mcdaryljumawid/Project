	<div class="modal-dialog modal-s">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">TRANSACTION DETAILS</h4>
        		</div>
        			<div class="modal-body" align="left"> 
        				<div class="container-fluid">
							<div class="row">
							<div class="col-sm-4"><strong>Transaction no:</strong>
							</div> 
							<div class="col-sm-4">{{$transaction->id}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Customer:</strong>
							</div> 
							<div class="col-sm-4">{{$transaction->customer->custlname}}, {{$transaction->customer->custfname}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Cashier/Manager:</strong>
							</div> 
							<div class="col-sm-4">{{$transaction->user->lastname}}, {{$transaction->user->firstname}}</div>
							</div>

							<div class="row">
							<div class="col-sm-4"><strong>Date:</strong>
							</div> 
							<div class="col-sm-4">{{ date('M d, Y', strtotime($transaction->created_at)) }}</div>
							</div>

							
							<div class="row">
							<div class="col-sm-4"><strong>Services availed:</strong>
							</div> 
							<div class="col-sm-4"><strong>Worker assigned:</strong>
							</div> <br>
							@foreach($transactiondetails as $transactiondetail)
								<div class="col-sm-4">{{$transactiondetail->service->servicename}}</div>
								<div class="col-sm-4">{{$transactiondetail->worker->workerlname}}, {{$transactiondetail->worker->workerfname}}</div><br>
							@endforeach
							</div>
					</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
							</div>
						</div>	
					</div>
				</div>
			</div>	
