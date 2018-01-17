	<div class="modal-dialog modal-s">
      	<!-- Modal content-->
      		<div class="modal-content">
        		<div class="modal-header" style="background-color: #808080;color: #fff;">
          			<h4 class="modal-title" align="center">DELETE TRANSACTION DETAIL</h4>
        		</div>
        		<form class="form-horizontal" method="PATCH" action="/transactions/{transaction}/deletetransactiondetail " id="add-transactiondetails-form">
					{{ csrf_field() }}
        			<div class="modal-body" align="left"> 
        				<div class="container-fluid">

							<div class="form-group">
                            <label class ="control-label col-sm-4">Service and Worker</label>
                            <div class="col-sm-7">
                            	<select class="select form-control " id="id" name="id" style="width: 300px">
                            		@foreach($transactiondetails as $transactiondetail)
                            		<option value="{{ $transactiondetail->id }}"> {{ $transactiondetail->service->servicename }} : {{ $transactiondetail->worker->workerlname }}, {{ $transactiondetail->worker->workerfname }}
                            		@endforeach</option>
                                </select>
								<span class="help-text text-danger"></span>
                            </div>
                        	</div>
                        </div>
                       </div>
							<div class="modal-footer">
								<div align="center">
								<button type="button" class="delete-transactiondetail-btn btn btn-danger">Delete Transaction Detail</button>
								<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
								</div>
							</div>
							</form>
						</div>
					</div>

<script type="text/javascript">
	$(document).off('click','.delete-transactiondetail-btn').on('click','.delete-transactiondetail-btn', function(e){
          e.preventDefault();
          var that = this;
          var $id =  $("select[name='id'").val(); 
                bootbox.confirm({
                  title: "Confirm Delete Transaction Detail?",
                  className: "del-bootbox",
                  message: "Are you sure you want to delete transaction detail?",
                  buttons: {
                      confirm: {
                          label: 'Yes',
                          className: 'btn-success'
                      },
                      cancel: {
                          label: 'No',
                          className: 'btn-danger'
                      }
                  },
                  callback: function (result) {
                     if(result){
                      var token = '{{csrf_token()}}'; 
                      $.ajax({
                      url:'/transactions/'+$id+'/deletetransactiondetails',
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        //$("#workers-table").DataTable().ajax.url( '/workers/get_datatable' ).load();
                        if(result.success){
                        swal({
                            title: result.msg,
                            icon: "success"
                          });
                		}
                		else
                		{
                			swal({
                            title: result.msg,
                            icon: "error"
                          });
                		}
                      }
                      }); 
                     }
                  }
              });
        });
</script>


