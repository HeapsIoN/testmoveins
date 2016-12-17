
$('body').on('click', '.unit-size', function(){
	var usize = $(this).attr('unit-size');
	$('#unitsizes').val(usize);
	$('#unitcats').val(null);
	$('.unit-size').not($(this)).removeClass('bg-7');
	$(this).addClass('bg-7');
	$('.unit').not($('.unit-type-'+usize)).slideUp(350);
	$('.unit-type-'+usize).delay(350).slideDown(350);
	});


