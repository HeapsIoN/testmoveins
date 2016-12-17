///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// StorMan Software Pty Ltd
// Javascript and jQuery Initialiser
// Author: Luke Pelgrave [Pelco Consulting]

var hasmce = 1;

$(document).ready(function(e) {

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// Loading Complete and Alert Handling

$('#loading').fadeOut(250);

$('.alert').animate({'right':'0px'},350).delay(4000).animate({'right':'-'+$('.alert').width()+'px'},350,0,function(){$('.alert').remove()});

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// Toolbar Detection and Formatting

toolbarDisplay();

resizeElements();

$(window).resize(function()
	{
	toolbarDisplay();
	
	resizeElements();
	
	});


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// Form Tab Handling

$('body').on('click', '.form-tab', function(){
	var grp = $(this).attr('sm-tab');
	
	$('.group').not($('#'+grp)).fadeOut(350);
	$('#'+grp).delay(350).fadeIn(350);
	
	$('.form-tab').not($(this)).removeClass('bg-1');
	$(this).addClass('bg-1');
	});


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// AJAX Handling

////////////////////////////////////////////
// AJAX Form Processing
$('body').on('click', '.form-button', function(){
	////////////////////////////////////////////
	showLoader();
	ajaxPreActions();
	////////////////////////////////////////////
	if(hasmce==2){tinymce.triggerSave();}
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var index 		= $('#index').attr('name'),
		smpform 	= $(this).attr('smp-form'),
		process 	= $('#'+smpform).attr('smp-process'),
		action 		= $('#'+smpform).attr('smp-action'),
		linkout 	= $('#'+smpform).attr('action'),
		postdata 	= $('#'+smpform).serializeArray();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/'+process+'/'+action,
		data: postdata,
		}).done(function(data){
		ajaxPostActions(data, linkout);	
		});
	////////////////////////////////////////////	
	});

////////////////////////////////////////////
// Toolbar Saving Simulator
$('body').on('click', '.tb-save', function(){
	$('.form-button:first').click();
	});

////////////////////////////////////////////
// Enter Handling for Forms
$('.input').not('.input-login, .input-search').bind('keydown', function(event){
	var keycode = (event.keyCode ? event.keyCode : (event.which ? event.which : event.charCode));
	if(keycode == 13){$('.tool-save:first').click();return false;} 
	else{return true;};
	}); 


});



function toolbarDisplay()
	{
	if($('#toolbar').length > 0)
		{
		var tpos = $('#toolbar').offset(),
			thgt = $('#toolbar').height(),
			nwid = $('#left-nav').width(),
			ftop = 0;
		
		$('#toolbar').css({'position':'fixed', 'top':tpos.top, 'left':nwid+'px', 'right':'0px'});	
		
		$('#search').css('margin-top', thgt+'px');
		
		if($('#form-tabs').length > 0)
			{
			ftop = parseFloat(tpos.top + 20);
			$('#form-tabs').css({'position':'fixed', 'top':tpos.top});		
			$('#form').css('margin-top', ftop+'px');
			}
		else
			{
			$('#form').css('margin-top', thgt+'px');	
			}
		}	
	}

function resizeElements()
	{
	if($(window).width() <= 767)
		{
		$('#left-nav').width('0px');	
		}
	else if($(window).width() <= 991)
		{
		$('#left-nav').width('25%');	
		}
	else if($(window).width() >= 992)
		{
		$('#left-nav').width('16.667%');	
		}	
	}


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// AJAX Pre and Post Actions

function ajaxPreActions()
	{
		
	}


function ajaxPostActions(data, linkout)
	{
	if(data.error)
		{
		displayResponse(data.error, 'error');
		}
	else if(data.success)
		{
		if(data.itemid)
			{
			$('#index').val(data.itemid);	
			}
		
		if(linkout != null)
			{
			window.location.replace(linkout);
			}
		else
			{			
			displayResponse(data.success, 'success');
			
			$('.needs-id').slideDown(350);
			
			formPostUpdate(data)
			}
		}	
	}

function showLoader()
	{
	$('#loading').fadeIn(250);	
	}


function formPostUpdate(result)
	{
	// Placeholder for use in individual includes to run script after AJAX POST
	}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
// Response Display

function displayResponse(message, type)
	{
	switch(type)
		{
		case 'error':
		var alertDisplay = '<div class="alert alert-error">'+ message +'</div>';
		break;
		case 'success':
		var alertDisplay = '<div class="alert alert-success">'+ message +'</div>';
		break;
		case 'unknown':
		var alertDisplay = '<div class="alert alert-warning">'+ message +'</div>';
		break;
		}
	
	$('body').append(alertDisplay);
	var movement = $('.alert').width();
	$('.alert').animate({'right':'0px'},350).delay(4000).animate({'right':'-'+movement+'px'},350,0,function(){$('.alert').remove()});
	
	$('#loading').delay(250).fadeOut(250);
	}

function displayLoadMessage()
	{
	if($('.alert').length > 0)
		{
		var movement = $('.alert').width();
		$('.alert').animate({'right':'0px'},350).delay(4000).animate({'right':'-'+movement+'px'},350,0,function(){$('.alert').remove()});
		$('#loading').delay(250).fadeOut(250);	
		}
	}