///////////////////////////////////////////////
///////////////////////////////////////////////
// StorMan Software Pty Ltd
// Login.js Functionality
// Author: Luke Pelgrave [Pelco Consulting]

$('body').on('click', '#enter', function(){
	
	var user = $('#user').val();
	var code = $('#pass').val()!='' ? $.md5($('#pass').val()) : '';
	
	$.ajax({
		type: 'POST',
		url: '/ajax/portal/login',
		data: {user:user, pass:code},
		}).done(function(data){
		if(data.error)
		{
		displayResponse(data.error, 'error');
		}
		else if(data.success)
		{
		if(data.redirect)
			{
			$('#login-form').attr('action', data.redirect);
			}
		
		$('#login-form').submit();
		}
		});
	
	});

$('.input-login').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){$('#enter').click();return false;} 
	else{return true;};
	});
