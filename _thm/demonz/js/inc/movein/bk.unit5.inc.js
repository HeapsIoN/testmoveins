
$('body').on('change', '#unit-category', function(){
	var ucat = $(this).val();
	
	$('#unitsizes').val(null);
	$('#unitcats').val(ucat);
	
	$('#unit-sizes').slideDown(350);
	$('.unit-size').not('.unit-size-'+ucat).addClass('hdn');
	$('.unit-size-'+ucat).delay(350).removeClass('hdn');
	
	showAvail();
	});

$('body').on('change', '#unit-size', function(){
	$('#unitsizes').val($(this).val());
	
	showAvail();
	});


function showAvail()
	{
	$('#unit-unmatched').slideUp(350);
	$('#unitcode, #unitrate').val(null);
	$('.unit-option').removeClass('bg-7');
	$('.unit-data').removeClass('txt-1').addClass('txt-7');
	$('.unit').slideUp(350);
	
	if($('#unitsizes').val()!=null)
		{
		var ucat = 	$('#unitsizes').val();
		
		console.log('Match:unit-type-'+ucat);
			
		$('.unit').not($('.unit-type-'+ucat)).slideUp(350);
		
		$('.unit-type-'+ucat).delay(350).slideDown(350,0,function(){
			if($('.unit').is(':visible').length==0)
				{
				$('#unit-unmatched').slideDown(350);
				$('.unit-type-msg').slideUp(350);	
				}
			else
				{
				$('.unit-type-msg').slideDown(350);	
				}
			});	
		}
	
	}
