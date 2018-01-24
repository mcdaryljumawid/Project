@extends('layouts.master')
<!--@include('script')-->
@section('title')
	Manage Customers | Moley Boley Online Appointment and Operations Management System
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
    <button class="add-data-btn btn btn-success">Add New Customer</button>
  </div>
<table id="customers-table" class="table" style="font-size: 15px;">
	<thead style="font-weight: bold;">
		<tr>
			<td>ID</td>
			<td>Username</td>
			<td>Firstname</td>
			<td>Middlename</td>
			<td>Lastname</td>
      <td>Gender</td>
      <td>Contact No.</td>
      <td>E-mail</td>
			<td>Actions</td>
		</tr>
	</thead>
  <tfoot style="font-weight: bold;">
    <tr>
      <td>ID</td>
      <td>Username</td>
      <td>Firstname</td>
      <td>Middlename</td>
      <td>Lastname</td>
      <td>Gender</td>
      <td>Contact No.</td>
      <td>E-mail</td>
      <td>Actions</td>
    </tr>
  </tfoot>
</table>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="editmodal"></div>

<script type="text/javascript">
	$(function() {
        $('#customers-table').DataTable({
                bprocessing: true,
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                  },
                  title: 'Moley Boley | Customers'
                },
                {
                  extend: 'excel',
                  exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                  },
                  title: 'Moley Boley | Customers'
                },
                {
                  extend: 'pdf',
                  exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                  },
                  title: 'Moley Boley | Customers'
                },
                {
                  extend: 'print',
                   exportOptions:{
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                  },
                  title: 'Moley Boley | Customers'
                },
                ],
            ajax: '/customers/get_datatable',
            columns: [
                {data: 'id', name: 'id', className: 'col-md-1 text-left'},
                {data: 'custUsername', name: 'custUsername', className: 'col-md-1 text-left'},
                {data: 'custfname', name: 'custfname', className: 'col-md-1 text-left'},
                {data: 'custmname', name: 'custmname', className: 'col-md-1 text-left'},
                {data: 'custlname', name: 'custlname', className: 'col-md-1 text-left'},
                {data: 'custgender', name: 'custgender', className: 'col-md-1 text-left'},
                {data: 'custContactNo', name: 'custContactNo', className: 'col-md-1 text-left'},
                {data: 'email', name: 'email', className: 'col-md-1 text-left'},
                {data: 'action', name: 'action', className: 'col-md-1 text-left', orderable: false, searchable: false}
            ]
        });

        $(".add-data-btn").click(function(x){  
              x.preventDefault();
              var that = this;
              $("#addmodal").html('');
              $("#addmodal").modal();
              $.ajax({
                url: '/customers/create',         
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
            url: '/customers/'+that.dataset.id+'/edit',         
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
                      url:'/customers/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#customers-table").DataTable().ajax.url( '/customers/get_datatable' ).load();
                        if(result.success)
                        {
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