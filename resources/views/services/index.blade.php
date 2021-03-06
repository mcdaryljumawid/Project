@extends('layouts.master')
@section('title')
	Manage Services | Moley Boley Online Appointment and Operations Management System
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
  <div align="center">
    <button class="add-data-btn btn btn-success">Add New Service</button>
  </div>
<table id="services-table" class="table" style="font-size: 15px;">
	<thead style="font-weight: bold;">
		<tr>
        <td>Service ID</td>
			  <td>Service type</td>
			  <td>Service name</td>
			  <td>Price</td>
			  <td>Duration (minutes)</td>
        <td>Category</td>
        <td>Status</td>
        <td>Actions</td>
		</tr>
	</thead>
  <tfoot style="font-weight: bold;">
    <tr>
        <td>Service ID</td>
        <td>Service type</td>
        <td>Service name</td>
        <td>Price</td>
        <td>Duration (minutes)</td>
        <td>Category</td>
        <td>Status</td>
        <td>Actions</td>
    </tr>
  </tfoot>
</table>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="editmodal"></div>

<script type="text/javascript">
	$(function() {
        $('#services-table').DataTable({
                bProcessing: true,
                sServerSide: false,
                sServerMethod: "GET",
                dom: 'Bfrtip',
                buttons: [
                {
                  extend: 'pageLength'
                },
                {
                  extend: 'copy',
                  exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                  },
                  title: 'Moley Boley | Services Offered'
                },
                {
                  extend: 'excel',
                  exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                  },
                  title: 'Moley Boley | Services Offered'
                },
                {
                  extend: 'pdf',
                  exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                  },
                  title: 'Moley Boley | Services Offered'
                },
                {
                  extend: 'print',
                   exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                  },
                  title: 'Moley Boley | Services Offered'
                },
                ],
            ajax: '/services/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'servicetype', name: 'servicetype', className: 'col-md-1 text-left', orderable: false},
                {data: 'servicename', name: 'servicename', className: 'col-md-1 text-left'},
                {data: 'serviceprice', name: 'serviceprice', className: 'col-md-1 text-left'},
                {data: 'serviceduration', name: 'serviceduration', className: 'col-md-1 text-left'},
                {data: 'servicecategory', name: 'servicecategory', className: 'col-md-1 text-left', orderable:false, searchable: true},
                {data: 'status', name: 'status', className: 'col-md-1 text-left'},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ],

            initComplete: function () {
            this.api().columns(1).every( function () {
                var column = this;
                var select = $('<select><option value="">Service Type</option></select>')
                    .appendTo( $(column.footer()).empty() )
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
                });
            } );

            this.api().columns(5).every( function () {
                var column = this;
                var select = $('<select><option value="">Category</option></select>')
                    .appendTo( $(column.footer()).empty() )
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

            this.api().columns(6).every( function () {
                var column = this;
                var select = $('<select><option value="">Status</option></select>')
                    .appendTo( $(column.footer()).empty() )
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
                url: '/services/create',         
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
            url: '/services/'+that.dataset.id+'/edit',         
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
                      url:'/services/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#services-table").DataTable().ajax.url( '/services/get_datatable' ).load();
                        if(result.success){
                        swal({
                            title: result.msg,
                            icon: "success"
                          });
                      }else
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
    });
</script>
</div>
@extends('layouts.footer')