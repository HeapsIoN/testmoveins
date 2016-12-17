
$('body').on('change', '#unit-size', function(){
	var usize = $(this).val();
	
	$('#unitsizes').val(usize);
	$('#unitcats').val(null);
	
	$('#unit-categories').slideDown(350);
	$('#unit-category').val(null);
	
	showAvail();
	});

$('body').on('change', '#unit-category', function(){
	$('#unitcats').val($(this).val());
	showAvail();
	});


function showAvail()
	{
	$('#unit-unmatched').slideUp(350);
	$('#unitcode, #unitrate').val(null);
	
	$('.unit').slideUp(350);
	if($('#unitcats').val()!=null)
		{
		var ucat = 	$('#unitsizes').val()+$('#unitcats').val();
			
		$('.unit').not($('.unit-type-'+ucat)).slideUp(350);
		
		$('.unit-type-'+ucat).delay(350).slideDown(350,0,function(){
			if($('.unit').is(':visible').length==0)
				{
				$('#unit-unmatched').removeClass('hdn').slideDown(350);
				$('.unit-type-msg').slideUp(350);	
				}
			else
				{
				$('.unit-type-msg').slideDown(350);	
				}
			});	
		}
	
	}
