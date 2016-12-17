// JavaScript Document

$(document).ready(function() {
	
$('.signature').signaturePad({
	drawOnly:true,
	bgColour:'#f8f8f8',
	lineTop:110,
	penColour:'#00a9c1',
	clear:$('.clearsign')
	});



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
			
			setTimeout(function(){window.location.replace('/summary')}, 3000);
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


function extraCheckboxChecks()
	{
	$('body').on('click', '.nf-chk', function(){
	
	var fld = $(this),
		inp = $(this).children('input').attr('id');
	
	if(inp=='extrainsurance')
		{
		if(fld.attr('is-chkd')=='y')
			{
			$('#extra-insurance').slideDown(250);
			}
		else
			{
			$('#extra-insurance').slideUp(250);	
			}
		}
	});
	}