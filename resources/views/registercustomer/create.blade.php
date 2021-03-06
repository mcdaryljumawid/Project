<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" align="center"><h4>CUSTOMER REGISTRATION FORM</h4></div>

                <div class="panel-body">

                <form class="form-horizontal" method="POST" action="/registercustomer" id="register-customer-form">
                    {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4">First Name</label>
                            <div class="col-sm-7">
                                <input id="custfname" type="text" class="form-control"  placeholder="First Name" name="custfname" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4">Middle Name</label>
                            <div class="col-sm-7">
                                <input id="custmname" type="text" class="form-control"  placeholder="Middle Name" name="custmname" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4">Last Name</label>
                            <div class="col-sm-7">
                                <input id="custlname" type="text" class="form-control"  placeholder="Last Name" name="custlname" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Username</label>
                            <div class="col-sm-7">
                                <input id="custUsername" type="text" class="form-control"  placeholder="User Name" name="custUsername" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Password</label>
                            <div class="col-sm-7">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Confirm Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required>
                                <span class="help-text text-danger"></span>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="control-label col-sm-4">Contact Number</label>
                            <div class="col-sm-7">
                                <input id="custContactNo" type="text" class="form-control"  placeholder="Contact Number" name="custContactNo" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="control-label col-sm-4">Email</label>
                            <div class="col-sm-7">
                                <input id="email" type="text" class="form-control"  placeholder="email@example.com" name="email" required autofocus><span class="help-text text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Gender</label>
                            <div class="col-sm-7">
                                <form>
                                    <select class="select form-control" id="custgender" name="custgender" required>
                                      <option value="Male">Male</option>
                                      <option value="Female">Female</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <div class="form-group">
                            <div align="center">
                                <button type="submit" class="submit-btn btn btn-success">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(document).off('click','.submit-btn').on('click','.submit-btn', function(e){
            e.preventDefault();
            var $form = $('#register-customer-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#register-customer-form").serialize(), 
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
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });
     });  
</script>