@extends('layouts.master')
@section('title')
	Manage Workers | Moley Boley Online Appointment and Operations Management System
@endsection
@include('script')
<br><br><br>
<div class="container" id="needs-validation" novalidate>
  <!-- Trigger the modal with a button -->
<br><br>
<div class="container-fluid mt-4">
    @include('errors')
    @include('success')
</div>

<div>
<button class="add-data-btn btn btn-success">Add Worker</button>
<table id="workers-table" class="table">
	<thead>
		<tr>
			<td>Worker ID</td>
			<td>Firstname</td>
			<td>Middlename</td>
			<td>Lastname</td>
			<td>Level</td>
      <td>Type</td>
      <td>Status</td>
			<td>Actions</td>
		</tr>
	</thead>
</table>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="viewmodal"></div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="editmodal"></div>


<script type="text/javascript">
	$(function() {
        $('#workers-table').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax: '/workers/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'workerfname', name: 'workerfname', className: 'col-md-1 text-left'},
                {data: 'workermname', name: 'workermname', className: 'col-md-1 text-left'},
                {data: 'workerlname', name: 'workerlname', className: 'col-md-1 text-left'},
                {data: 'workerlevel', name: 'workerlevel', className: 'col-md-1 text-left', orderable: false,},
                {data: 'workertype', name: 'workertype', className: 'col-md-1 text-left'},
                {data: 'status', name: 'status', className: 'col-md-1 text-left'},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
            initComplete: function () {
            this.api().columns(4).every( function () {
                var column = this;
                var select = $('<select><option value="">Level</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
        });

        $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#addmodal").html('');
              $("#addmodal").modal();
              $.ajax({
                url: '/workers/create',         
                success: function(data) {
                  $("#addmodal").html(data);
                }
              }); 
        });

        $(document).off('click','.view-data-btn').on('click','.view-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#viewmodal").html('');
          $("#viewmodal").modal();
          $.ajax({
            url: '/workers/'+that.dataset.id+'',         
            success: function(data) {
              $("#viewmodal").html(data);
            }
          }); 
        });

        $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#editmodal").html('');
          $("#editmodal").modal();
          $.ajax({
            url: '/workers/'+that.dataset.id+'/edit',         
            success: function(data) {
              $("#editmodal").html(data);
            }
          }); 
        });

         $(document).off('click','.delete-data-btn').on('click','.delete-data-btn', function(e){
          e.preventDefault();
          var that = this; 
                bootbox.confirm({
                  title: "Confirm Delete Data?",
                  className: "del-bootbox",
                  message: "Are you sure you want to delete record?",
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
                      url:'/workers/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#workers-table").DataTable().ajax.url( '/workers/get_datatable' ).load();
                        swal({
                            title: result.msg,
                            icon: "success"
                          });
                      }
                      }); 
                     }
                  }
              });
        });

    });
</script>
</div>
@extends('layouts.footer')