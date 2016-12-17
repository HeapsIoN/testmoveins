// JavaScript Document

$(window).on('resize', function(){
	$('#signature-wrapper').css({'width':$('.well:first').width()+'px', 'overflow':'hidden'});
	});

$(document).ready(function() {
	
$('.signature').signaturePad({
	drawOnly:true,
	bgColour:'#f8f8f8',
	lineTop:110,
	penColour:'#00a9c1',
	clear:$('.clearsign')
	});

$('#signature-wrapper').css({'width':$('.well:first').width()+'px', 'overflow':'hidden'});


$('body').on('click', '#generate', function(){
	////////////////////////////////////////////
	showLoader();
	////////////////////////////////////////////
	$('#loading').show();
	////////////////////////////////////////////
	var postdata 	= $('#form').serializeArray();
	////////////////////////////////////////////
	$.ajax({
		type: 'POST',
		url: '/ajax/movein/accept',
		data: postdata,
		}).done(function(data){
		if(data.error)
			{
			displayResponse(data.error, 'error')	
			}
		else
			{
			displayResponse(data.success, 'success');
			
			setTimeout(function(){window.location.replace(data.redirect)}, 3000);
			}
		});
	////////////////////////////////////////////
	});


$('#full-terms').on('scroll', function(){
	
	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight)
		{
		$('#accepter').slideDown(350);
		$('#scroll-msg').slideUp(350);
		}	
	});

	
});

function extraRadioChecks(opt)
	{
	var fld = opt.attr('opt-fld'),
		val = $('#'+fld).val();
		
	if(fld=='insuranceprovider')
		{
		switch(val)
			{
			// Facility
			case '1':
			$('#insurance-row').slideDown(350);
			$('#insurancebroker-row').slideUp(350);
			break;
			// Broker
			case '2':
			$('#insurancebroker-row').slideDown(350);
			$('#insurance-row').slideUp(350);	
			break;
			// None
			case '3':
			$('#insurance-row, #insurancebroker-row').slideUp(350);	
			break;	
			}	
		}
	}


function extraCheckboxChecks()
	{
	$('body').on('click', '.nf-chk', function(){
	
	var fld = $(this),
		inp = $(this).children('input').attr('id');
	
	if(inp=='extrainsurance')
		{
		if(fld.attr('is-chkd')=='y')
			{
			$('#insuranceprovider-row').slideDown(250);
			}
		else
			{
			$('#insuranceprovider-row').slideUp(250);	
			}
		}
	});
	}