
$('body').on('click', '.unit-category', function(){
	var ucat = $(this).attr('unit-category');
	$('#unitsizes').val(null);
	$('#unitcats').val(ucat);
	$('.unit-category').not($(this)).removeClass('bg-7');
	$(this).addClass('bg-7');
	$('.unit').not($('.unit-type-'+ucat)).slideUp(350);
	$('.unit-type-'+ucat).delay(350).slideDown(350);
	});


