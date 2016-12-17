// JavaScript Document

radioLoadingSelected();

$('#profile').valida({form_validate:'validate'});

$('body').on('click', '#existing-btn', function(){
	$('#account-type, #confirm-email-row').addClass('storman-hdn');
	$('#customeremail').attr('readonly', 'readonly').addClass('bg-lgt-grey');
	$('#password-msg').html('<p>You can update your password below or leave it blank to continue. If updating your password, it must be at least 6 characters. You will also need to confirm the new password.</p>');
	$('#profile').slideUp(350);
	$('#form-title').html('Account Manager');
	});

$('body').on('click', '#register-btn', function(){
	$('input, select, #customercode').not('#isbusiness, #ordermoveinday, #ordermoveinmonth, #ordermoveinyear').val(null);
	$('#account-type, #email-confirm-row').removeClass('storman-hdn');
	$('#customeremail, #customeremailc').attr('required', 'required').attr('readonly', null).removeClass('bg-lgt-grey');
	$('#password-msg').html('<p>Please enter the password for your account. Min. length of 6 characters. You will also need to confirm the password.</p>');
	$('#profile').slideDown(350);
	$('#form-title').html('New Customer Registration');
	$('html, body').animate({scrollTop: $("#account-type").offset().top}, 500);
	});


$('body').on('change', '#isbusiness', function(){toggleType('#isbusiness')});

 

$('.login-input').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){$('#logincustomer').click();return false;} 
	else{return true;};
	}); 

$('body').on('click', '#logincustomer', function(){
	////////////////////////////////////////////
	showLoader();
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var postdata 	= $('#login').serializeArray();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/movein/login',
		data: postdata,
		}).done(function(data){
		if(data.error)
			{
			displayResponse(data.error, 'error')	
			}
		else
			{
			displayResponse(data.success, 'success');
			
			if(data.accounts)
				{
				if($('#dialog').length > 0)
					{
					$('#dialog').html(data.accounts);	
					}
				else
					{
					$('body').append('<div id="dialog">'+ data.accounts +'</div>');	
					}
				
				$('body').on('click', '.select-code', function(){
					$('.select-code').not($(this)).removeClass('bg-8').removeClass('selected-code');
					$(this).addClass('bg-8').addClass('selected-code');
					});
				
				$('#dialog').dialog({
					resizable: false,
					height:'auto',
					width:500,
					modal: true,
					dialogClass: 'myDialog',
					title: 'Select Account',
					buttons: 
						{
						'Login': function() {
							$('#dialog').dialog('close');
							$('#loading').show();				
							var postdata = {confirmid:$('.selected-code').attr('my-id')};
							
							$.ajax({
								type: 'POST',
								url: '/ajax/movein/confirm',
								data: postdata,
							}).done(function(data){
								if(data.success)
									{
									displayResponse(data.success, 'success');
									
									$.each(data.customer, function(k, v){
										if($('#'+k).length > 0)
											{
											$('#'+k).val(v);
											$('#profile').valida('partial', '#'+k);		
											}
										});	
								
									$('#login, #newcomer, #account-type, .pass-row, #confirm-email-row, #can-login, .register-only').slideUp(350);
									$('#profile, #account-tools, #email-row').slideDown(350,0,function(){$('#email-row').removeClass('storman-hdn')});
									$('#customeremail').attr('required', null).attr('readonly', 'readonly');
									$('.register-only, #customeremailc').attr('required', null).attr('disabled', 'disabled');
									$('#isbusiness').val(data.customer.isbusiness).after(function(){toggleType('#isbusiness');radioLoadingSelected()});
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
						},
						'Cancel': function() {
							$('#dialog').dialog('close');
						}
					}});
				}
			else
				{				
				$.each(data.customer, function(k, v){
					if($('#'+k).length > 0)
						{
						$('#'+k).val(v);
						$('#profile').valida('partial', '#'+k);		
						}
					});	
			
				$('#login, #newcomer, #account-type, .pass-row, #confirm-email-row, .register-only').slideUp(350);
				$('#customeremail').attr('required', null).attr('readonly', 'readonly');
				$('#profile, #account-tools, #email-row').slideDown(350,0,function(){$('#email-row').removeClass('storman-hdn')});
				$('.register-only, #customeremailc').attr('required', null).attr('disabled', 'disabled');
				
				$('#isbusiness').val(data.customer.isbusiness).after(function(){toggleType('#isbusiness');radioLoadingSelected()});
				
				}
			}
		});
	////////////////////////////////////////////
	});


$('body').on('click', '#whatsalt', function(){
	
	if($('#dialog').length > 0)
		{
		$('#dialog').html('Please enter the information of a third person we can contact, in the event that we lose contact with you. The facility may also discuss default with this person in the event that you become unwilling or unable to meet obligations under the contract. We may negotiate directly with this person including releasing the goods stored in your unit/space to them.');	
		}
	else
		{
		$('body').append('<div id="dialog">Please enter the information of a third person we can contact, in the event that we lose contact with you. The facility may also discuss default with this person in the event that you become unwilling or unable to meet obligations under the contract. We may negotiate directly with this person including releasing the goods stored in your unit/space to them.</div>');	
		}
	
	$('#dialog').dialog(
		{
			resizable: false,
			height:'auto',
			width:500,
			modal: true,
			dialogClass: 'myDialog',
			title: 'What Is This?'
		});
	
	
	
	});



$('body').on('click', '.save-customer', function(){
	////////////////////////////////////////////
	showLoader();
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var postdata 	= $('#profile').serializeArray(), 
		msg			= '';
	
	$.each(postdata, function(k, v){
		var r = $('#profile').valida('partial', '#'+v.name);
		
		if(r===false)
			{
			if($('#'+v.name).attr('data-invalid')!='' && $('#'+v.name).attr('data-invalid')!='undefined')
				{
				msg = msg+$('#'+v.name).attr('data-invalid')+'<br/>';	
				}
			else
				{
				msg = msg+'Data missing. Field ID: '+v.name+'<br/>';
				}
			}
		});
	
	
	if(msg!='')
		{
		displayResponse(msg, 'error');	
		}
	else
		{
		////////////////////////////////////////////
		$.ajax({
			type: 'POST',
			url: '/ajax/movein/profile',
			data: postdata,
			}).done(function(data){
			ajaxPostActions(data, '/contract');
			});
		////////////////////////////////////////////
		}
	});



$('.suburb-finder').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: '/ajax/movein/suburb',
			dataType: "json",
			data: {term : request.term},
			success: function(data) {response(data);}
		});
	},
	minLength: 2,
	select: function( event, ui ) {
			var tag = $(this).attr('ac-tag');
			$('#'+tag+'suburb').val(ui.item.suburb);
			$('#'+tag+'state').val(ui.item.state);
			$('#'+tag+'postcode').val(ui.item.postcode);
			$('#profile').valida('partial', '#'+tag+'suburb');
			$('#profile').valida('partial', '#'+tag+'state');
			$('#profile').valida('partial', '#'+tag+'postcode');
			return false;
	},
	open: function(event, ui) {
        $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
    }});


$('body').on('click', '#reset-loader', function(){
	
	var dia = '<p>You must enter both your customer code and email address. The system will find your profile, reset your password and send it to your email address.</p><label for="resetuser" class="col-xs-12 lh-50 txt-md pad-none">Customer Code*</label><input type="text" id="resetuser" class="input col-xs-12 lh-50 bdr-s-1 bdr-4 mrg-b-md" placeholder="Enter your customer code"><label for="resetemail" class="lh-50 txt-md pad-none">Email*</label><input type="text" id="resetemail" class="input col-xs-12 lh-50 bdr-s-1 bdr-4 mrg-b-md" placeholder="Enter your email address">';
	
	if($('#dialog').length > 0)
		{
		$('#dialog').html(dia);	
		}
	else
		{
		$('body').append('<div id="dialog">'+ dia +'</div>');	
		}
	
	$('#dialog').dialog({
			resizable: false,
			height:'auto',
			width:500,
			modal: true,
			dialogClass: 'myDialog',
			title: 'Reset Password',
			buttons: 
				{
				'Reset Password': function() {
					$('#dialog').dialog('close');
					$('#loading').show();				
					var postdata = {user:$('#resetuser').val(),email:$('#resetemail').val()};
					
					$.ajax({
						type: 'POST',
						url: '/ajax/movein/resetpass',
						data: postdata,
					}).done(function(data){
						if(data.success)
							{
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
				},
				'Cancel': function() {
					$('#dialog').dialog('close');
				}
			}});
	
	});



$('.input-reset').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){$('#resetpass').click();return false;} 
	else{return true;};
	});


function togglerSets(type)
	{
		
	}

	
function extraCheckboxChecks()
	{
	$('body').on('click', '.nf-chk', function(){
	
	var fld = $(this),
		inp = $(this).children('input').attr('id');
	
	if(inp=='mailingsame')
		{
		if(!$('#'+inp).attr('disabled'))
			{
			$('#customermailaddress').val($('#customeraddress').val());
			$('#customermailsuburb').val($('#customersuburb').val());
			$('#customermailstate').val($('#customerstate').val());
			$('#customermailpostcode').val($('#customerpostcode').val());
			$('#profile').valida('partial', '#customermailaddress');
			$('#profile').valida('partial', '#customermailsuburb');
			$('#profile').valida('partial', '#customermailstate');			
			$('#profile').valida('partial', '#customermailpostcode');
			
			}
		}
	
	if(inp=='secondarysame')
		{
		if(!$('#'+inp).attr('disabled'))
			{
			$('#customeraltaddress').val($('#customeraddress').val());
			$('#customeraltsuburb').val($('#customersuburb').val());
			$('#customeraltstate').val($('#customerstate').val());
			$('#customeraltpostcode').val($('#customerpostcode').val());
			
			$('#profile').valida('partial', '#customeraltaddress');
			$('#profile').valida('partial', '#customeraltsuburb');
			$('#profile').valida('partial', '#customeraltstate');			
			$('#profile').valida('partial', '#customeraltpostcode');
			
			}
		}	
	});
	}


function toggleType(fld)
	{
	var flds = $(fld).children('option:selected').attr('storman-flds'),
		mtch = '';
	
	flds = flds=='' || flds=='undefined' ? 'residential' : flds;
	
	switch(flds)
		{
		case 'residential':
		$('.business').slideUp(350, 0, function(){$('.business').not('.residential.business').addClass('storman-hdn');});
		$('.residential').slideDown(350, 0, function(){$('.residential').not('.residential.business').removeClass('storman-hdn')});
		$('#customerfirstname').attr('placeholder', 'Enter your first name*');
		$('#customersurname').attr('placeholder', 'Enter your surname*');
		$('.res-only').attr('disabled', null);
		$('.bus-only').attr('disabled', 'disabled');
		$('#customerfirstname, #customersurname').parent('.col-xs-12').removeClass('col-md-4').addClass('col-md-5');
		mtch = 'res';
		break;
		case 'business':
		$('.residential').slideUp(350, 0, function(){$('.residential').not('.residential.business').addClass('storman-hdn')});
		$('.business').slideDown(350, 0, function(){$('.business').not('.residential.business').removeClass('storman-hdn')});
		$('#customerfirstname').attr('placeholder', 'Enter your company name*');
		$('#customersurname').attr('placeholder', 'Enter the company contact name*');
		$('.res-only').attr('disabled', 'disabled');
		$('.bus-only').attr('disabled', null);
		$('#customerfirstname, #customersurname').parent('.col-xs-12').removeClass('col-md-5').addClass('col-md-4');
		mtch = 'bus';
		break;	
		}
	
	$('.control-label').each(function(index, element) {
        
		if($(this).attr(mtch+'-lbl'))
			{
			$(this).html($(this).attr(mtch+'-lbl'));	
			}
    	});
	
	$('.form-control').each(function(index, element) {
        
		if($(this).attr(mtch+'-ph'))
			{
			$(this).attr('placeholder', $(this).attr(mtch+'-ph'));
			$(this).attr('data-invalid', $(this).attr(mtch+'-err'));	
			}
    	});
	
	if($('#customercode').val()!='' && $('#customercode').val()!=null)
		{
		$('.continue-row').slideDown(350);
		$('#confirm-email-row, .pass-row').slideUp(350).addClass('storman-hdn');	
		}
	else
		{
		$('.continue-row').slideUp(350);
		$('.pass-row').slideDown(350);
		$('#email-row, #confirm-email-row').removeClass('storman-hdn');
		}
		
	}
