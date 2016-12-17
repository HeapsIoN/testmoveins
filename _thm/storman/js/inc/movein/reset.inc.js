///////////////////////////////////////////////
///////////////////////////////////////////////
// StorMan Software Pty Ltd
// reset.inc.js
// Author: Luke Pelgrave [Pelco Consulting]

$('body').on('click', '#reset', function(){
	
	var user = $('#userreset').val();
	
	$.ajax({
		type: 'POST',
		url: '/ajax/moveins/resetpass',
		data: {user:user},
		}).done(function(data){
		if(data.error)
		{
		displayResponse(data.error, 'error');
		}
		else if(data.success)
		{
		$('#login-form').submit();
		}
		});
	
	});

$('.input-reset').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){$('#reset').click();return false;} 
	else{return true;};
	});
