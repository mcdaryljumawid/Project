	<div class="modal-dialog modal-s">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">BILL</h4>
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

							<br>
							<div class="row">
							<div class="col-sm-4"><strong>Services availed:</strong>
							</div> 
							<div class="col-sm-4"><strong>Worker assigned:</strong>
							</div> <br>
							@if(sizeof($transactiondetails) > 0)
								@foreach($transactiondetails as $transactiondetail)
								<div class="col-sm-4">{{$transactiondetail->service->servicename}}</div>
								<div class="col-sm-4">{{$transactiondetail->worker->workerlname}}, {{$transactiondetail->worker->workerfname}}</div><br>
								@endforeach
								<br>
								<div align="center">
								<h4><strong>Total bill:</h4><h4 style="color: green;">₱ {{ number_format($sum, 2, '.', ',') }}</h4></strong>
								</div>
							@else
								<h4><strong>No transaction details found.</strong></h4>
							@endif
							</div>

							<form class="form-horizontal" method="PATCH" action="/transactions/{{ $transaction->id }}/finalizepayment " id="payment-form">
								{{ csrf_field() }}
								<input type="hidden" id="transaction_id" name="transaction_id" value="{{ $transaction->id }}">
							</form>
					</div>
							<div class="modal-footer">
								<div align="center">
								<button type="button" class="payment-btn btn btn-success">Finalize Payment</button>
								<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>

<script type="text/javascript">
	$(function(){
		$(document).off('click','.payment-btn').on('click','.payment-btn', function(e){
	    	e.preventDefault();
	        var $form = $('#payment-form');
	        var $url = $form.attr('action');
	        $.ajax({
	          type: 'PATCH',
	          url: $url,
	          data: $("#payment-form").serialize(), 
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
	            $("#transactions-table").DataTable().ajax.url( '/transactions/get_datatable' ).load();
	            $("#closed-transactions-table").DataTable().ajax.url( '/transactions/get_datatable_closedtransactions' ).load();
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


