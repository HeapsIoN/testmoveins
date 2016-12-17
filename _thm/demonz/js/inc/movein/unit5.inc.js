
if($('#unitsizes').val()!='' && $('#unitsizes').val()!=null)
	{
	$('.unit-msg').show();	
	}


$('body').on('change', '#unit-category', function(){
	var ucat = $(this).val();
	
	$('#unitsizes').val(null);
	$('#unitcats').val(ucat);
	
	$('#unit-sizes').slideDown(350);
	$('#unit-size').val(null);
	
	showAvail();
	});

$('body').on('change', '#unit-size', function(){
	$('#unitsizes').val($(this).val());
	
	showAvail();
	});


function showAvail()
	{
	$('.unit-msg, #unit-unmatched').slideUp(350);
	$('#unitcode, #unitrate').val(null);
	$('.unit-option').removeClass('bg-7');
	$('.unit-data').removeClass('txt-1').addClass('txt-7');
	$('.unit').slideUp(350);
	
	if($('#unitsizes').val()!=null && $('#unitsizes').val()!='')
		{
		var ucat = 	$('#unitcats').val()+$('#unitsizes').val();
			
		$('.unit').not($('.unit-type-'+ucat)).slideUp(350);
		
		
		$('.unit-type-'+ucat).delay(350).slideDown(350,0,function(){
			if($('.unit-type-'+ucat).is(':visible').length==0)
				{
				$('#unit-unmatched').removeClass('hdn').slideDown(350);
				$('.unit-msg, .unit-type-msg').slideUp(350);	
				}
			else
				{
				$('.unit-msg, .unit-type-msg').slideDown(350);	
				}
			});	
		}
	
	}
