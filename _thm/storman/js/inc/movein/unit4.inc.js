
$('body').on('click', '.unit-size', function(){
	var usize = $(this).attr('unit-size');
	$('.unit-size').removeClass('bg-7');
	$(this).addClass('bg-7');	
	
	$('#unitsizes').val(usize);
	$('#unitcats').val(null);
	
	$('#unit-categories').slideDown(350);
	$('.unit-category-size').not('.unit-category-size.unit-size-'+usize).slideUp(350);
	$('.unit-category-size.unit-size-'+usize).delay(350).slideDown(350);
	
	
	showAvail();
	});

$('body').on('click', '.unit-category', function(){
	$('#unitcats').val($(this).attr('unit-category'));
	$('.unit-category.bg-7').removeClass('bg-7');
	$(this).addClass('bg-7');
	
	showAvail();
	});


function showAvail()
	{
	$('#unit-unmatched').slideUp(350);
	$('#unitcode, #unitrate').val(null);
	$('.unit-option').removeClass('bg-7');
	$('.unit-data').removeClass('txt-1').addClass('txt-4');
	
	$('.unit').slideUp(350);
	if($('#unitcats').val()!=null)
		{
		var ucat = 	$('#unitcats').val();
		
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
