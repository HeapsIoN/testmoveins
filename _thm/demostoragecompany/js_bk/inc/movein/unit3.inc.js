
$('body').on('change', '#unit-size', function(){
	var usize = $(this).val();
	$('#unitsizes').val(usize);
	$('#unitcats').val(null);
	$('.unit').not($('.unit-type-'+usize)).slideUp(350);
	$('.unit-type-'+usize).delay(350).slideDown(350);
	});


