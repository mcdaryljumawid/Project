<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/datatables.bootstrap.js"></script>
<script type="text/javascript" src="/js/handlebars.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.0.0/jquery.mark.min.js"></script>
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<!--<script type="text/javascript" src="/js/jquery-1.12.4.js"></script>-->
<script type="text/javascript" src="/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="/js/jszip.min.js"></script>
<script type="text/javascript" src="/js/pdfmake.min.js"></script>
<script type="text/javascript" src="/js/vfs_fonts.js"></script>
<script type="text/javascript" src="/js/buttons.print.min.js"></script>
<script type="text/javascript" src="/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="/js/numcount.js"></script>
<script type="text/javascript" src="/plug-ins/sum().js"></script>
<!--<script src="{{ asset('js/app.js') }}"></script>-->
<script type="text/javascript">
	function associate_errors(errors, $form)
	{	 
	    //remove existing error classes and error messages from form groups
	    $form.find('.form-group').removeClass('has-error').find('.help-text').text('');
	   
	    $.each(errors, function(value, index){
	        //find each form group, which is given a unique id based on the form field's name  add the error class and set the error text
	        $('input#'+value).parent().addClass('has-error').find('.help-text').text(index);
	    });
	}
</script>