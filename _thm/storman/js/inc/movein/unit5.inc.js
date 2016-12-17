
$('body').on('click', '.unit-category', function(){
	var ucat = $(this).attr('unit-category');
	$('.unit-category').not($(this)).removeClass('bg-4');
	$(this).addClass('bg-4');	
	
	$('#unitsizes').val(null);
	$('#unitcats').val(ucat);
	
	$('#unit-sizes').slideDown(350);
	$('.unit-category-size').not('.unit-category-size.unit-category-'+ucat).slideUp(350);
	$('.unit-category-size.unit-category-'+ucat).delay(350).slideDown(350);
	
	
	showAvail();
	});

$('body').on('click', '.unit-size', function(){
	$('#unitsizes').val($(this).attr('unit-size'));
	$('.unit-size').not($(this).parent('.unit-size')).removeClass('bg-7');
	$(this).addClass('bg-7');
	
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
				}
			});	
		}
	
	}
