@extends('layouts.master')
@section('title')
	Manage Users | Moley Boley Online Appointment and Operations Management System
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
<button class="add-data-btn btn btn-success">Add User</button>
<table id="users-table" class="table">
	<thead>
		<tr>
			<td>User ID</td>
			<td>Firstname</td>
			<td>Middlename</td>
			<td>Lastname</td>
			<td>Role</td>
			<td>Actions</td>
		</tr>
	</thead>
</table>

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="editmodal"></div>

<script type="text/javascript">
	$(function() {
        $('#users-table').DataTable({
              bProcessing: true,
              bServerSide: false,
              sServerMethod: "GET",
            ajax: '/users/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'firstname', name: 'firstname', className: 'col-md-1 text-left'},
                {data: 'middlename', name: 'middlename', className: 'col-md-1 text-left'},
                {data: 'lastname', name: 'lastname', className: 'col-md-1 text-left'},
                {data: 'role', name: 'role', className: 'col-md-1 text-left', orderable: false,},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],
            initComplete: function () {
            this.api().columns(4).every( function () {
                var column = this;
                var select = $('<select><option value="">Role</option></select>')
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
        }
        });
//call the modal from the triggering button
        $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#addmodal").html('');
              $("#addmodal").modal();
              $.ajax({
                url: '/users/create',         
                success: function(data) {
                  $("#addmodal").html(data);
                }
              }); 
        });

        $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          $("#editmodal").html('');
          $("#editmodal").modal();
          $.ajax({
            url: '/users/'+that.dataset.id+'/edit',         
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
                      url:'/users/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#users-table").DataTable().ajax.url( '/users/get_datatable' ).load();
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