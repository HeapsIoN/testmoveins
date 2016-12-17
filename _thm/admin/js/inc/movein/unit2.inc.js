
if($('#unitcats').val()!='' && $('#unitcats').val()!=null)
	{
	$('.unit-msg').show();	
	}

$('body').on('change', '#unit-category', function(){
	var ucat = $(this).val();
	$('#unitsizes').val(null);
	$('#unitcats').val(ucat);
	$('.unit').not($('.unit-type-'+ucat)).slideUp(350);
	$('.unit-msg, .unit-type-'+ucat).delay(350).slideDown(350);
	});


