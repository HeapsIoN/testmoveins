// JavaScript Document

$('body').on('click', '#account-tgl', function(){
		$('#sub-menu').slideToggle(350);
	});

$('body').on('click', '#logout-confirm', function(){
	if($('#dialog').length <= 0)
		{
		$('body').append('<div id="dialog"></div>');
		}
	
	var msg = $('#short-logout').length > 0 ? '<p>Are you sure you want to log out?</p>' : '<p>Are you sure you want to log out?</p><p>This will cancel your order as well as log you out.</p>';
	
	$('#dialog').html(msg);
	
	$('#dialog').dialog({
		resizable: false,
		height:'auto',
		width:600,
		modal: true,
		dialogClass: 'myDialog',
		title: 'Confirm Account Logout',
		buttons: 
			{
			'Yes, Log Me Out': function() {
				window.location.replace('/logout');
				
			},
			'Cancel': function() {
				$('#dialog').dialog("close");
			}
		}});
	
	});

$('body').on('click', '#password-modal', function(){
	$('body').append('<div id="dialog"></div>');
	$('#sub-menu').slideUp(350);
	$('#dialog').html('<form id="pu"><div class="col-xs-12"><p>Please enter and confirm the new password.</p></div><div class="col-xs-12"><label for="customerpassword_modal" class="lbl col-xs-12 alg-lft txt-md">Password</label><input type="password" filter="min_length:6" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-md" id="customerpassword_modal" placeholder="Enter a password for your account*"* required data-invalid="Password must be at least 6 characters long" /></div><div class="col-xs-12"><label for="confirmpassword_modal" class="lbl col-xs-12 alg-lft txt-md">Confirm Password</label><input type="password" filter="min_length:6|matches:customerpassword_modal" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-md" id="confirmpassword_modal" data-match-error="The passwords do not match" placeholder="Confirm the password for your account*" required data-invalid="The password must be at least 6 characters and match the password" /></div></form>');
	
	$('#dialog').dialog({
		resizable: false,
		height:'auto',
		width:600,
		modal: true,
		dialogClass: 'myDialog',
		title: 'Set Account Password',
		open: function(){$('#pu').valida()},
		buttons: 
			{
			'Update Password': function() {
				var msg = '';
				
				var p = $('#pu').valida('partial', '#customerpassword_modal');
				if(p===false)
					{
					msg = msg+$('#customerpassword_modal').attr('data-invalid')+'<br/>';
					}
				
				var c = $('#pu').valida('partial', '#confirmpassword_modal');
				if(c===false)
					{
					msg = msg+$('#confirmpassword_modal').attr('data-invalid')+'<br/>';
					}
				
				if(msg=='')
					{
					$('#dialog').dialog("close");
					showLoader();
					
					$.ajax({
						type: 'POST',
						url: '/ajax/movein/update',
						data: {newpass:$('#customerpassword_modal').val(),newpasc:$('#confirmpassword_modal').val()},
					}).done(function(data){
						if(data.success)
							{
							$('#dialog').dialog("close");
							displayResponse(data.success, 'success');
							}
						else if(data.error)
							{
							displayResponse(data.error, 'error');	
							}
						else
							{
							displayResponse('An unknown error occurred.', 'unknown');	
							}
						});	
					}
				else
					{
					displayResponse(msg, 'error');	
					}
			},
			'Cancel': function() {
				$('#dialog').dialog("close");
			}
		}});
	
	});




$('body').on('click', '#email-modal', function(){
	$('body').append('<div id="dialog"></div>');
	$('#sub-menu').slideUp(350);
	$('#dialog').html('<form id="pu"><div class="col-xs-12"><p>Please enter and confirm your new email address.</p></div><div class="col-xs-12"><label for="customeremail_modal" class="lbl col-xs-12 alg-lft txt-md">New Email</label><input type="email" filter="email" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-md" id="customeremail_modal" placeholder="Enter an updated email address for your account*"* required data-invalid="The email address is invalid" /></div><div class="col-xs-12"><label for="confirmemail_modal" class="lbl col-xs-12 alg-lft txt-md">Confirm Email</label><input type="email" filter="email|matches:customeremail_modal" class="input col-xs-12 bdr-3 txt-lg txt-4 mrg-b-md" id="confirmemail_modal" placeholder="Confirm the email address for your account*" required data-invalid="The email address is invalid or is not the same as the above" /></div></form>');
	
	$('#dialog').dialog({
		resizable: false,
		height:'auto',
		width:600,
		modal: true,
		dialogClass: 'myDialog',
		title: 'Update Account Email',
		open: function(){$('#pu').valida()},
		buttons: 
			{
			'Update Acount': function() {
				
				var msg = '';
				
				var p = $('#pu').valida('partial', '#customeremail_modal');
				
				if(p===false)
					{
					msg = msg+$('#customeremail_modal').attr('data-invalid')+'<br/>';
					}
				
				var c = $('#pu').valida('partial', '#confirmemail_modal');
				if(c===false)
					{
					msg = msg+$('#confirmemail_modal').attr('data-invalid')+'<br/>';
					}
				
				if(msg=='')
					{
					$('#dialog').dialog("close");
					showLoader();
					
					$.ajax({
						type: 'POST',
						url: '/ajax/movein/update',
						data: {newemail:$('#customeremail_modal').val(),newemaic:$('#confirmemail_modal').val()},
					}).done(function(data){
						if(data.success)
							{
							$('#dialog').dialog("close");
							displayResponse(data.success, 'success');
							$('#customeremail').val(data.email);
							}
						else if(data.error)
							{
							displayResponse(data.error, 'error');	
							}
						else
							{
							displayResponse('An unknown error occurred.', 'unknown');	
							}
						});	
					}
				else
					{
					displayResponse(msg, 'error');	
					}
			},
			'Cancel': function() {
				$('#dialog').dialog("close");
			}
		}});
	
	});